@php
    $tabs = [
        ['key' => 'general', 'label' => 'General', 'href' => route('sistemas.show', $sistema) . '?tab=general'],
        ['key' => 'tecnologias', 'label' => 'Tecnologías', 'href' => route('sistemas.show', $sistema) . '?tab=tecnologias', 'can' => 'sistemas.manage_tech'],
        ['key' => 'ambientes', 'label' => 'Ambientes', 'href' => route('sistemas.show', $sistema) . '?tab=ambientes', 'can' => 'sistemas.manage_infra'],
        ['key' => 'releases', 'label' => 'Releases', 'href' => route('sistemas.show', $sistema) . '?tab=releases'],
    ];
    
    $filteredTabs = collect($tabs)->filter(function($tab) {
        return !isset($tab['can']) || auth()->user()->can($tab['can']);
    })->values()->all();
@endphp

<x-tabs :items="$filteredTabs" :active="request('tab', 'general')" />
