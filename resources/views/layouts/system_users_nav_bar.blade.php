@php
    $menuprivilegearray = $menuaccess ?? [];

    if (!function_exists('menucheck')) {
        function menucheck($arraymenu, $menuID) {
            if(!is_array($arraymenu) && !is_object($arraymenu)) return 0;
            foreach ($arraymenu as $array) {
                if (isset($array->menuid) && $array->menuid == $menuID && $array->access_status == 1) return 1;
            }
            return 0;
        }
    }
@endphp

<div class="flex flex-nowrap py-1.5 relative z-50">
    <div class="flex flex-wrap gap-2">
        @if(menucheck($menuprivilegearray, 2)==1)
        <a role="button" class="px-4 py-2 text-sm font-medium text-gray-800 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors no-underline navbtncolor" href="{{ url('User/Useraccount') }}" id="useraccount_link">User Account <span class="caret"></span></a>
        @endif

        @if(menucheck($menuprivilegearray, 3)==1)
        <a role="button" class="px-4 py-2 text-sm font-medium text-gray-800 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors no-underline navbtncolor" href="{{ url('User/Usertype') }}" id="usertype_link">User Type <span class="caret"></span></a>
        @endif

        @if(menucheck($menuprivilegearray, 4)==1)
        <a role="button" class="px-4 py-2 text-sm font-medium text-gray-800 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors no-underline navbtncolor" href="{{ url('User/Userprivilege') }}" id="userprivilege_link">User Privilege <span class="caret"></span></a>
        @endif
    </div>
</div>
