@php
$links = 
[
    [
        "header_text" => "Dashboard",
        "is_multi" => false,
        "list" =>
        [
            [
                "text" => "Dashboar",
                "icon" => "fab fa-gripfire",
                "href" => "dashboard",
                "is_dropdown" => false,
            ],
        ],  
    ],
    [
        "header_text" => "Admin User",
        "is_multi" => true,
        "href" => 
        [
            [
                "section_text" => "User",
                "section_icon" => "far fa-user",
                "section_list" => 
                [
                    ["href" => "user", "text" => "Data User"],
                    ["href" => "user.new", "text" => "Buat User"]
                ]
            ]
        ],
    ],
    [
        "header_text" => "Fiter Barber",
        "is_multi" => false,
        "list" => 
        [
            [
                "is_dropdown" => true,
                "href" => 
                [
                    [
                        "section_text" => "Transaksi",
                        "section_icon" => "far fa-plus-square",
                        "section_list" => 
                        [
                            ["href" => "pemasukan", "text" => "Pemasukan"],
                            ["href" => "pengeluaran", "text" => "Pengeluaran"],
                            ["href" => "libur", "text" => "Libur"],
                            ["href" => "bon", "text" => "Bon"],
                        ]
                    ],
                    [
                        "section_text" => "Laporan",
                        "section_icon" => "far fa-bookmark",
                        "section_list" => 
                        [
                            ["href" => "laporanpemasukan", "text" => "Pemasukan"],
                            ["href" => "laporankeuangan", "text" => "Keuangan"],
                            ["href" => "laporanharian", "text" => "Harian"],
                        ]
                    ]
                ],
            ],
            [
                "text" => "Pegawai",
                "icon" => "far fa-address-book",
                "href" => "pegawai",
                "is_dropdown" => false,
            ],
            [
                "text" => "Keterangan",
                "icon" => "fas fa-tags",
                "href" => "keterangan",
                "is_dropdown" => false,
            ]
        ],
    ],
];
$navigation_links = array_to_object($links);
@endphp

<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">Fiter Barber</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">
                <img class="d-inline-block" width="32px" height="30.61px" src="" alt="">
            </a>
        </div>
        @foreach ($navigation_links as $link)
        <ul class="sidebar-menu">
            <li class="menu-header">{{ $link->header_text }}</li>
            @if (!$link->is_multi)
                @foreach ($link->list as $lists)
                    @if (!$lists->is_dropdown)
                        <li class="{{ Request::routeIs($lists->href) ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route($lists->href) }}"><i class="{{ $lists->icon }}"></i><span>{{ $lists->text }}</span></a>
                        </li>
                    @else
                        @foreach ($lists->href as $section)
                            @php
                            $routes = collect($section->section_list)->map(function ($child) {
                                return Request::routeIs($child->href);
                            })->toArray();

                            $is_active = in_array(true, $routes);
                            @endphp

                            <li class="dropdown {{ ($is_active) ? 'active' : '' }}">
                                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="{{ $section->section_icon }}"></i> <span>{{ $section->section_text }}</span></a>
                                <ul class="dropdown-menu">
                                    @foreach ($section->section_list as $child)
                                        <li class="{{ Request::routeIs($child->href) ? 'active' : '' }}"><a class="nav-link" href="{{ route($child->href) }}">{{ $child->text }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    @endif
                @endforeach
            @else
                @foreach ($link->href as $section)
                    @php
                    $routes = collect($section->section_list)->map(function ($child) {
                        return Request::routeIs($child->href);
                    })->toArray();

                    $is_active = in_array(true, $routes);
                    @endphp

                    <li class="dropdown {{ ($is_active) ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="{{ $section->section_icon }}"></i> <span>{{ $section->section_text }}</span></a>
                        <ul class="dropdown-menu">
                            @foreach ($section->section_list as $child)
                                <li class="{{ Request::routeIs($child->href) ? 'active' : '' }}"><a class="nav-link" href="{{ route($child->href) }}">{{ $child->text }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            @endif
        </ul>
        @endforeach
    </aside>
</div>
