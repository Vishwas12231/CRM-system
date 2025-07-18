<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Http\Resources\LeadResource;
use App\Jobs\SendLeadAssignedEmail;
use App\Models\Lead;
use App\Models\LeadActivity;
use App\Models\User;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Display a listing of leads.
     * Admin: all leads
     * Agent: only assigned leads
     */
    public function index() 
    {
        $user = auth()->user();
        $leads = $user->is_admin ? Lead::all() : Lead::where('assigned_to', $user->id)->get();
        return LeadResource::collection($leads);
    }

    /**
     * Store a newly created lead.
     */
    public function store(StoreLeadRequest $request) 
    {
        $lead = Lead::create($request->validated());
        LeadActivity::create(['lead_id' => $lead->id, 'user_id' => auth()->id(), 'action' => 'commented', 'notes' => 'Created']);
        return new LeadResource($lead);
    }

    /**
     * Assign a lead to a user.
     */
    public function assign(Request $request, Lead $lead) 
    {
        $lead->assigned_to = $request->assigned_to;
        $lead->save();
        LeadActivity::create(['lead_id' => $lead->id, 'user_id' => auth()->id(), 'action' => 'assigned', 'notes' => 'Assigned to user ' . $request->assigned_to]);
        dispatch(new SendLeadAssignedEmail($lead, User::find($request->assigned_to)));
        return response()->json(['message' => 'Assigned']);
    }

    /**
     * Display the specified lead.
     */
    public function show(Lead $lead)
    {
        $this->authorize('view', $lead);

        return new LeadResource($lead);
    }

    /**
     * Update the specified lead.
     */
    public function update(UpdateLeadRequest $request, Lead $lead)
    {
        $this->authorize('update', $lead);

        $lead->update($request->validated());

        LeadActivity::create([
            'lead_id' => $lead->id,
            'user_id' => auth()->id(),
            'action' => 'status_updated',
            'notes' => 'Lead updated',
        ]);

        return new LeadResource($lead);
    }

    /**
     * Remove the specified lead from storage.
     */
    public function destroy(Lead $lead)
    {
        $this->authorize('delete', $lead);

        $lead->delete();

        LeadActivity::create([
            'lead_id' => $lead->id,
            'user_id' => auth()->id(),
            'action' => 'commented',
            'notes' => 'Lead deleted',
        ]);

        return response()->json(['message' => 'Lead deleted successfully.']);
    }
}
