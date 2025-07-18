@component('mail::message')
# New Lead Assigned

Hello,

A new lead has been assigned to you.

**Name:** {{ $lead->first_name }} {{ $lead->last_name }}  
**Email:** {{ $lead->email }}  
**Phone:** {{ $lead->phone }}  
**Status:** {{ ucfirst($lead->status) }}

@component('mail::button', ['url' => url('/leads/' . $lead->id)])
View Lead
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent
