@if(!Session::get('navigations'))
{{ navigationMenuListing() }}
@endif
@if(Session::get('navigations') && count(Session::get('navigations')))
    @foreach(Session::get('navigations') as $key => $value)
        @if(isset($value["children"]) && count($value["children"]))
            <li class='{{ Request::is("{$value["action_path"]}*") ? "active" : "" }} treeview'>
                <a href="#">
                    <i class="fa {{ $value['icon'] }}"></i> <span>{{ App::getLocale() == "en" ? $value['en_name'] : $value['name'] }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                @if(isset($value["children"]) && count($value["children"]))
                <ul class="treeview-menu">
                    @foreach($value["children"] as $row)
                        <li class="{{ Request::is($row['action_path']) ? 'active' : '' }}">
                            <a href="{{ systemLink($row['action_path']) }}"><i class="fa fa-circle-o"></i> {{ App::getLocale() == "en" ? $row['en_name'] : $row['name'] }}</a>
                        </li>
                    @endforeach
                </ul>
                @endif
            </li>
        @else 
            <li class='{{ Request::is("{$value["action_path"]}*") ? "active" : "" }}'>
                <a href="{{ systemLink($value['action_path']) }}">
                    <i class="fa {{ $value['icon'] }}"></i> <span>{{ App::getLocale() == "en" ? $value['en_name'] : $value['name'] }}</span>
                </a>
            </li>
        @endif
    @endforeach
@endif
