<div class="col-md-10 col-sm-10 col-md-offset-1">
    <div class="clearfix visible-sm-block"></div>
    <div class="panel panel-chat shoutbox">
        <div class="panel-heading">
            <h4><i class="{{ config("other.font-awesome") }} fa-trophy"></i> @lang('blocks.top-torrents')</h4>
        </div>

        <ul class="nav nav-tabs mb-5" role="tablist">
            <li class="active">
                <a href="#newtorrents" role="tab" data-toggle="tab" aria-expanded="true">
                    <i class="{{ config('other.font-awesome') }} fa-trophy text-gold"></i> @lang('blocks.new-torrents')
                </a>
            </li>
            <li class="">
                <a href="#topseeded" role="tab" data-toggle="tab" aria-expanded="false">
                    <i class="{{ config('other.font-awesome') }} fa-arrow-up text-success"></i> @lang('torrent.top-seeded')
                </a>
            </li>
            <li class="">
                <a href="#topleeched" role="tab" data-toggle="tab" aria-expanded="false">
                    <i class="{{ config('other.font-awesome') }} fa-arrow-down text-danger"></i> @lang('torrent.top-leeched')
                </a>
            </li>
            <li class="">
                <a href="#dyingtorrents" role="tab" data-toggle="tab" aria-expanded="false">
                    <i class="{{ config('other.font-awesome') }} fa-arrow-down text-red"></i> @lang('torrent.dying-torrents')
                    <i class="{{ config('other.font-awesome') }} fa-recycle text-red" data-toggle="tooltip"
                       data-original-title="@lang('torrent.requires-reseed')"></i>
                </a>
            </li>
            <li class="">
                <a href="#deadtorrents" role="tab" data-toggle="tab" aria-expanded="false">
                    <i class="{{ config('other.font-awesome') }} fa-exclamation-triangle text-red"></i> @lang('torrent.dead-torrents')
                    <i class="{{ config('other.font-awesome') }} fa-recycle text-red" data-toggle="tooltip"
                       data-original-title="@lang('torrent.requires-reseed')"></i>
                </a>
            </li>
        </ul>

        <div class="tab-content">

            <div class="tab-pane fade active in" id="newtorrents">
                <td class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered">
                        <thead>
                        <tr>
                            <th class="torrents-icon"></th>
                            <th class="torrents-filename">@lang('torrent.name')</th>
                            <th>@lang('torrent.age')</th>
                            <th>@lang('torrent.size')</th>
                            <th>@lang('torrent.short-seeds')</th>
                            <th>@lang('torrent.short-leechs')</th>
                            <th>@lang('torrent.short-completed')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($newest as $new)
                            <tr>
                                <td>
                                    @if ($new->category->image != null)
                                        <a href="{{ route('category', ['slug' => $new->category->slug, 'id' => $new->category->id]) }}">
                                            <div class="text-center">
                                                <img src="{{ url('files/img/' . $new->category->image) }}" data-toggle="tooltip"
                                                     data-original-title="{{ $new->category->name }} {{ strtolower(trans('torrent.torrent')) }}"
                                                     style="padding-bottom: 6px;" alt="{{ $new->category->name }}">
                                            </div>
                                        </a>
                                    @else
                                        <a href="{{ route('category', ['slug' => $new->category->slug, 'id' => $new->category->id]) }}">
                                            <div class="text-center">
                                                <i class="{{ $new->category->icon }} torrent-icon" data-toggle="tooltip"
                                                   data-original-title="{{ $new->category->name }} {{ strtolower(trans('torrent.torrent')) }}"
                                                   style="padding-bottom: 6px;"></i>
                                            </div>
                                        </a>
                                    @endif
                                    <div class="text-center">
                                        <span class="label label-success" data-toggle="tooltip" data-original-title="Type">
                                            {{ $new->type }}
                                        </span>
                                    </div>
                                 </td>

                                <td>
                                    <a class="text-bold" href="{{ route('torrent', ['slug' => $new->slug, 'id' => $new->id]) }}">
                                        {{ $new->name }}
                                    </a>
                                    @if (config('torrent.download_check_page') == 1)
                                        <a href="{{ route('download_check', ['slug' => $new->slug, 'id' => $new->id]) }}">
                                            <button class="btn btn-primary btn-circle" type="button" data-toggle="tooltip"
                                                    data-original-title="@lang('common.download')">
                                                <i class="{{ config('other.font-awesome') }} fa-download"></i>
                                            </button>
                                        </a>
                                    @else
                                        <a href="{{ route('download', ['slug' => $new->slug, 'id' => $new->id]) }}">
                                            <button class="btn btn-primary btn-circle" type="button" data-toggle="tooltip"
                                                    data-original-title="@lang('common.download')">
                                                <i class="{{ config('other.font-awesome') }} fa-download"></i>
                                            </button>
                                        </a>
                                    @endif

                                    <span data-toggle="tooltip" data-original-title="@lang('torrent.bookmark')" custom="newTorrentBookmark{{ $new->id }}" id="newTorrentBookmark{{ $new->id }}" torrent="{{ $new->id }}" state="{{ $bookmarks->where('torrent_id', $new->id)->count() ? 1 : 0}}" class="torrentBookmark"></span>

                                    <br>
                                    @if ($new->anon == 1)
                                        <span class="badge-extra text-bold">
                                        <i class="{{ config('other.font-awesome') }} fa-upload" data-toggle="tooltip" data-original-title="Uploaded By"></i> @lang('common.anonymous')
                                            @if ($user->id == $new->user->id || $user->group->is_modo)
                                                <a href="{{ route('profile', ['username' => $new->user->username, 'id' => $new->user->id]) }}">
                                                    ({{ $new->user->username }})
                                                </a>
                                            @endif
                                        </span>
                                    @else
                                        <span class="badge-extra text-bold">
                                        <i class="{{ config('other.font-awesome') }} fa-upload" data-toggle="tooltip" data-original-title="Uploaded By"></i> By
                                            <a href="{{ route('profile', ['username' => $new->user->username, 'id' => $new->user->id]) }}">
                                                {{ $new->user->username }}
                                            </a>
                                        </span>
                                    @endif

                                    <span class="badge-extra text-bold text-pink">
                                        <i class="{{ config('other.font-awesome') }} fa-heart" data-toggle="tooltip" data-original-title="Thanks Given"></i>
                                        {{ $new->thanks_count }}
                                    </span>

                                    <span class="badge-extra text-bold text-green">
                                        <i class="{{ config('other.font-awesome') }} fa-comment" data-toggle="tooltip" data-original-title="Comments Left"></i>
                                        {{ $new->comments_count }}
                                    </span>

                                    @if ($new->internal == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-magic' data-toggle='tooltip' title=''
                                                data-original-title='Internal Release' style="color: #baaf92;"></i> Internal
                                        </span>
                                    @endif

                                    @if ($new->stream == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-play text-red' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.stream-optimized')'></i> @lang('torrent.stream-optimized')
                                        </span>
                                    @endif

                                    @if ($new->featured == 0)
                                    @if ($new->doubleup == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-gem text-green' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.double-upload')'></i> @lang('torrent.double-upload')
                                        </span>
                                    @endif
                                    @if ($new->free == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-star text-gold' data-toggle='tooltip' title=''
                                                data-original-title='@lang('common.free')'></i> @lang('common.free')
                                        </span>
                                    @endif
                                    @endif

                                    @if ($personal_freeleech)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-id-badge text-orange' data-toggle='tooltip' title=''
                                                data-original-title='Personal FL'></i> Personal FL
                                        </span>
                                    @endif

                                    @if ($freeleech_tokens->where('torrent_id', $new->id)->count())
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-star text-bold' data-toggle='tooltip' title=''
                                                data-original-title='Freeleech Token'></i> Freeleech Token
                                        </span>
                                    @endif

                                    @if ($new->featured == 1)
                                        <span class='badge-extra text-bold' style='background-image:url(/img/sparkels.gif);'>
                                            <i class='{{ config("other.font-awesome") }} fa-certificate text-pink' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.feature')'></i> @lang('torrent.feature')
                                        </span>
                                    @endif

                                    @if ($user->group->is_freeleech == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-trophy text-purple' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.special-freeleech')'></i> @lang('torrent.special-freeleech')
                                        </span>
                                    @endif

                                    @if (config('other.freeleech') == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-globe text-blue' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.global-freeleech')'></i> @lang('torrent.global-freeleech')
                                        </span>
                                    @endif

                                    @if (config('other.doubleup') == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-globe text-green' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.global-double-upload')'></i> @lang('torrent.global-double-upload')
                                        </span>
                                    @endif

                                    @if ($new->leechers >= 5)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-fire text-orange' data-toggle='tooltip' title=''
                                                data-original-title='@lang('common.hot')'></i> @lang('common.hot')
                                        </span>
                                    @endif

                                    @if ($new->sticky == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-thumbtack text-black' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.sticky')'></i> @lang('torrent.sticky')
                                        </span>
                                    @endif

                                    @if ($user->updated_at->getTimestamp() < $new->created_at->getTimestamp())
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-magic text-green' data-toggle='tooltip' title=''
                                                data-original-title='@lang('common.new')'></i> @lang('common.new')
                                        </span>
                                    @endif

                                    @if ($new->highspeed == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-tachometer text-red' data-toggle='tooltip' title=''
                                                data-original-title='@lang('common.high-speeds')'></i> @lang('common.high-speeds')
                                        </span>
                                    @endif

                                    @if ($new->sd == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-ticket text-orange' data-toggle='tooltip' title=''
                                                data-original-title='SD Content!'></i> SD Content
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <span>{{ $new->created_at->diffForHumans() }}</span>
                                </td>
                                <td>
                                    <span>{{ $new->getSize() }}</span>
                                </td>
                                <td>
                                    <span>{{ $new->seeders }}</span>
                                </td>
                                <td>
                                    <span>{{ $new->leechers }}</span>
                                </td>
                                <td>
                                    <span>{{ $new->times_completed }}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            <div class="tab-pane fade" id="topseeded">
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered">
                        <thead>
                        <tr>
                            <th class="torrents-icon"></th>
                            <th class="torrents-filename">@lang('torrent.name')</th>
                            <th>@lang('torrent.age')</th>
                            <th>@lang('torrent.size')</th>
                            <th>@lang('torrent.short-seeds')</th>
                            <th>@lang('torrent.short-leechs')</th>
                            <th>@lang('torrent.short-completed')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($seeded as $seed)
                            <tr>
                                <td>
                                    @if ($seed->category->image != null)
                                        <a href="{{ route('category', ['slug' => $seed->category->slug, 'id' => $seed->category->id]) }}">
                                            <div class="text-center">
                                                <img src="{{ url('files/img/' . $seed->category->image) }}" data-toggle="tooltip"
                                                     data-original-title="{{ $seed->category->name }} {{ strtolower(trans('torrent.torrent')) }}"
                                                     style="padding-bottom: 6px;" alt="{{ $seed->category->name }}">
                                            </div>
                                        </a>
                                    @else
                                        <a href="{{ route('category', ['slug' => $seed->category->slug, 'id' => $seed->category->id]) }}">
                                            <div class="text-center">
                                                <i class="{{ $seed->category->icon }} torrent-icon" data-toggle="tooltip"
                                                   data-original-title="{{ $seed->category->name }} {{ strtolower(trans('torrent.torrent')) }}"
                                                   style="padding-bottom: 6px;"></i>
                                            </div>
                                        </a>
                                    @endif
                                    <div class="text-center">
                                        <span class="label label-success" data-toggle="tooltip" data-original-title="Type">
                                            {{ $seed->type }}
                                        </span>
                                    </div>
                                 </td>

                                <td>
                                    <a class="text-bold" href="{{ route('torrent', ['slug' => $seed->slug, 'id' => $seed->id]) }}">
                                        {{ $seed->name }}
                                    </a>
                                    @if (config('torrent.download_check_page') == 1)
                                        <a href="{{ route('download_check', ['slug' => $seed->slug, 'id' => $seed->id]) }}">
                                            <button class="btn btn-primary btn-circle" type="button" data-toggle="tooltip"
                                                    data-original-title="@lang('common.download')">
                                                <i class="{{ config('other.font-awesome') }} fa-download"></i>
                                            </button>
                                        </a>
                                    @else
                                        <a href="{{ route('download', ['slug' => $seed->slug, 'id' => $seed->id]) }}">
                                            <button class="btn btn-primary btn-circle" type="button" data-toggle="tooltip"
                                                    data-original-title="@lang('common.download')">
                                                <i class="{{ config('other.font-awesome') }} fa-download"></i>
                                            </button>
                                        </a>
                                    @endif

                                    <span data-toggle="tooltip" data-original-title="@lang('torrent.bookmark')" custom="seededTorrentBookmark{{ $seed->id }}" id="seededTorrentBookmark{{ $seed->id }}" torrent="{{ $seed->id }}" state="{{ $bookmarks->where('torrent_id', $seed->id)->count() ? 1 : 0}}" class="torrentBookmark"></span>

                                    <br>
                                    @if ($seed->anon == 1)
                                        <span class="badge-extra text-bold">
                                        <i class="{{ config('other.font-awesome') }} fa-upload" data-toggle="tooltip" data-original-title="Uploaded By"></i> @lang('common.anonymous')
                                            @if ($user->id == $seed->user->id || $user->group->is_modo)
                                                <a href="{{ route('profile', ['username' => $seed->user->username, 'id' => $seed->user->id]) }}">
                                                    ({{ $seed->user->username }})
                                                </a>
                                            @endif
                                        </span>
                                    @else
                                        <span class="badge-extra text-bold">
                                        <i class="{{ config('other.font-awesome') }} fa-upload" data-toggle="tooltip" data-original-title="Uploaded By"></i> By
                                            <a href="{{ route('profile', ['username' => $seed->user->username, 'id' => $seed->user->id]) }}">
                                                {{ $seed->user->username }}
                                            </a>
                                        </span>
                                    @endif

                                    <span class="badge-extra text-bold text-pink">
                                        <i class="{{ config('other.font-awesome') }} fa-heart" data-toggle="tooltip" data-original-title="Thanks Given"></i>
                                        {{ $seed->thanks_count }}
                                    </span>

                                    <span class="badge-extra text-bold text-green">
                                        <i class="{{ config('other.font-awesome') }} fa-comment" data-toggle="tooltip" data-original-title="Comments Left"></i>
                                        {{ $seed->comments_count }}
                                    </span>

                                    @if ($seed->internal == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-magic' data-toggle='tooltip' title=''
                                                data-original-title='Internal Release' style="color: #baaf92;"></i> Internal
                                        </span>
                                    @endif

                                    @if ($seed->stream == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-play text-red' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.stream-optimized')'></i> @lang('torrent.stream-optimized')
                                        </span>
                                    @endif

                                    @if ($seed->featured == 0)
                                    @if ($seed->doubleup == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-gem text-green' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.double-upload')'></i> @lang('torrent.double-upload')
                                        </span>
                                    @endif
                                    @if ($seed->free == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-star text-gold' data-toggle='tooltip' title=''
                                                data-original-title='@lang('common.free')'></i> @lang('common.free')
                                        </span>
                                    @endif
                                    @endif

                                    @if ($personal_freeleech)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-id-badge text-orange' data-toggle='tooltip' title=''
                                                data-original-title='Personal FL'></i> Personal FL
                                        </span>
                                    @endif

                                    @if ($freeleech_tokens->where('torrent_id', $seed->id)->count())
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-star text-bold' data-toggle='tooltip' title=''
                                                data-original-title='Freeleech Token'></i> Freeleech Token
                                        </span>
                                    @endif

                                    @if ($seed->featured == 1)
                                        <span class='badge-extra text-bold' style='background-image:url(/img/sparkels.gif);'>
                                            <i class='{{ config("other.font-awesome") }} fa-certificate text-pink' data-toggle='tooltip' title=''
                                               data-original-title='@lang('torrent.feature')'></i> @lang('torrent.feature')
                                        </span>
                                    @endif

                                    @if ($user->group->is_freeleech == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-trophy text-purple' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.special-freeleech')'></i> @lang('torrent.special-freeleech')
                                        </span>
                                    @endif

                                    @if (config('other.freeleech') == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-globe text-blue' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.global-freeleech')'></i> @lang('torrent.global-freeleech')
                                        </span>
                                    @endif

                                    @if (config('other.doubleup') == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-globe text-green' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.global-double-upload')'></i> @lang('torrent.global-double-upload')
                                        </span>
                                    @endif

                                    @if ($seed->leechers >= 5)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-fire text-orange' data-toggle='tooltip' title=''
                                                data-original-title='@lang('common.hot')'></i> @lang('common.hot')
                                        </span>
                                    @endif

                                    @if ($seed->sticky == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-thumbtack text-black' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.sticky')'></i> @lang('torrent.sticky')
                                        </span>
                                    @endif

                                    @if ($user->updated_at->getTimestamp() < $seed->created_at->getTimestamp())
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-magic text-green' data-toggle='tooltip' title=''
                                                data-original-title='@lang('common.new')'></i> @lang('common.new')
                                        </span>
                                    @endif

                                    @if ($seed->highspeed == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-tachometer text-red' data-toggle='tooltip' title=''
                                                data-original-title='@lang('common.high-speeds')'></i> @lang('common.high-speeds')
                                        </span>
                                    @endif

                                    @if ($seed->sd == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-ticket text-orange' data-toggle='tooltip' title=''
                                                data-original-title='SD Content!'></i> SD Content
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <span>{{ $seed->created_at->diffForHumans() }}</span>
                                </td>
                                <td>
                                    <span>{{ $seed->getSize() }}</span>
                                </td>
                                <td>
                                    <span>{{ $seed->seeders }}</span>
                                </td>
                                <td>
                                    <span>{{ $seed->leechers }}</span>
                                </td>
                                <td>
                                    <span>{{ $seed->times_completed }}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="topleeched">
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered">
                        <thead>
                        <tr>
                            <th class="torrents-icon"></th>
                            <th class="torrents-filename">@lang('torrent.name')</th>
                            <th>@lang('torrent.age')</th>
                            <th>@lang('torrent.size')</th>
                            <th>@lang('torrent.short-seeds')</th>
                            <th>@lang('torrent.short-leechs')</th>
                            <th>@lang('torrent.short-completed')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($leeched as $leech)
                            <tr>
                                <td>
                                    @if ($leech->category->image != null)
                                        <a href="{{ route('category', ['slug' => $leech->category->slug, 'id' => $leech->category->id]) }}">
                                            <div class="text-center">
                                                <img src="{{ url('files/img/' . $leech->category->image) }}" data-toggle="tooltip"
                                                     data-original-title="{{ $leech->category->name }} {{ strtolower(trans('torrent.torrent')) }}"
                                                     style="padding-bottom: 6px;" alt="{{ $leech->category->name }}">
                                            </div>
                                        </a>
                                    @else
                                        <a href="{{ route('category', ['slug' => $leech->category->slug, 'id' => $leech->category->id]) }}">
                                            <div class="text-center">
                                                <i class="{{ $leech->category->icon }} torrent-icon" data-toggle="tooltip"
                                                   data-original-title="{{ $leech->category->name }} {{ strtolower(trans('torrent.torrent')) }}"
                                                   style="padding-bottom: 6px;"></i>
                                            </div>
                                        </a>
                                    @endif
                                    <div class="text-center">
                                        <span class="label label-success" data-toggle="tooltip" data-original-title="Type">
                                            {{ $leech->type }}
                                        </span>
                                    </div>
                                 </td>

                                <td>
                                    <a class="text-bold" href="{{ route('torrent', ['slug' => $leech->slug, 'id' => $leech->id]) }}">
                                        {{ $leech->name }}
                                    </a>
                                    @if (config('torrent.download_check_page') == 1)
                                        <a href="{{ route('download_check', ['slug' => $leech->slug, 'id' => $leech->id]) }}">
                                            <button class="btn btn-primary btn-circle" type="button" data-toggle="tooltip"
                                                    data-original-title="@lang('common.download')">
                                                <i class="{{ config('other.font-awesome') }} fa-download"></i>
                                            </button>
                                        </a>
                                    @else
                                        <a href="{{ route('download', ['slug' => $leech->slug, 'id' => $leech->id]) }}">
                                            <button class="btn btn-primary btn-circle" type="button" data-toggle="tooltip"
                                                    data-original-title="@lang('common.download')">
                                                <i class="{{ config('other.font-awesome') }} fa-download"></i>
                                            </button>
                                        </a>
                                    @endif

                                    <span data-toggle="tooltip" data-original-title="@lang('torrent.bookmark')" custom="leechedTorrentBookmark{{ $leech->id }}" id="leechedTorrentBookmark{{ $leech->id }}" torrent="{{ $leech->id }}" state="{{ $bookmarks->where('torrent_id', $leech->id)->count() ? 1 : 0}}" class="torrentBookmark"></span>

                                    <br>
                                    @if ($leech->anon == 1)
                                        <span class="badge-extra text-bold">
                                        <i class="{{ config('other.font-awesome') }} fa-upload" data-toggle="tooltip" data-original-title="Uploaded By"></i> @lang('common.anonymous')
                                            @if ($user->id == $leech->user->id || $user->group->is_modo)
                                                <a href="{{ route('profile', ['username' => $leech->user->username, 'id' => $leech->user->id]) }}">
                                                    ({{ $leech->user->username }})
                                                </a>
                                            @endif
                                        </span>
                                    @else
                                        <span class="badge-extra text-bold">
                                        <i class="{{ config('other.font-awesome') }} fa-upload" data-toggle="tooltip" data-original-title="Uploaded By"></i> By
                                            <a href="{{ route('profile', ['username' => $leech->user->username, 'id' => $leech->user->id]) }}">
                                                {{ $leech->user->username }}
                                            </a>
                                        </span>
                                    @endif

                                    <span class="badge-extra text-bold text-pink">
                                        <i class="{{ config('other.font-awesome') }} fa-heart" data-toggle="tooltip" data-original-title="Thanks Given"></i>
                                        {{ $leech->thanks_count }}
                                    </span>

                                    <span class="badge-extra text-bold text-green">
                                        <i class="{{ config('other.font-awesome') }} fa-comment" data-toggle="tooltip" data-original-title="Comments Left"></i>
                                        {{ $leech->comments_count }}
                                    </span>

                                    @if ($leech->internal == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-magic' data-toggle='tooltip' title=''
                                                data-original-title='Internal Release' style="color: #baaf92;"></i> Internal
                                        </span>
                                    @endif

                                    @if ($leech->stream == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-play text-red' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.stream-optimized')'></i> @lang('torrent.stream-optimized')
                                        </span>
                                    @endif

                                    @if ($leech->featured == 0)
                                    @if ($leech->doubleup == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-gem text-green' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.double-upload')'></i> @lang('torrent.double-upload')
                                        </span>
                                    @endif
                                    @if ($leech->free == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-star text-gold' data-toggle='tooltip' title=''
                                                data-original-title='@lang('common.free')'></i> @lang('common.free')
                                        </span>
                                    @endif
                                    @endif

                                    @if ($personal_freeleech)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-id-badge text-orange' data-toggle='tooltip' title=''
                                                data-original-title='Personal FL'></i> Personal FL
                                        </span>
                                    @endif

                                    @if ($freeleech_tokens->where('torrent_id', $leech->id)->count())
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-star text-bold' data-toggle='tooltip' title=''
                                                data-original-title='Freeleech Token'></i> Freeleech Token
                                        </span>
                                    @endif

                                    @if ($leech->featured == 1)
                                        <span class='badge-extra text-bold' style='background-image:url(/img/sparkels.gif);'>
                                            <i class='{{ config("other.font-awesome") }} fa-certificate text-pink' data-toggle='tooltip' title=''
                                               data-original-title='@lang('torrent.feature')'></i> @lang('torrent.feature')
                                        </span>
                                    @endif

                                    @if ($user->group->is_freeleech == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-trophy text-purple' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.special-freeleech')'></i> @lang('torrent.special-freeleech')
                                        </span>
                                    @endif

                                    @if (config('other.freeleech') == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-globe text-blue' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.global-freeleech')'></i> @lang('torrent.global-freeleech')
                                        </span>
                                    @endif

                                    @if (config('other.doubleup') == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-globe text-green' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.global-double-upload')'></i> @lang('torrent.global-double-upload')
                                        </span>
                                    @endif

                                    @if ($leech->leechers >= 5)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-fire text-orange' data-toggle='tooltip' title=''
                                                data-original-title='@lang('common.hot')'></i> @lang('common.hot')
                                        </span>
                                    @endif

                                    @if ($leech->sticky == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-thumbtack text-black' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.sticky')'></i> @lang('torrent.sticky')
                                        </span>
                                    @endif

                                    @if ($user->updated_at->getTimestamp() < $leech->created_at->getTimestamp())
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-magic text-green' data-toggle='tooltip' title=''
                                                data-original-title='@lang('common.new')'></i> @lang('common.new')
                                        </span>
                                    @endif

                                    @if ($leech->highspeed == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-tachometer text-red' data-toggle='tooltip' title=''
                                                data-original-title='@lang('common.high-speeds')'></i> @lang('common.high-speeds')
                                        </span>
                                    @endif

                                    @if ($leech->sd == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-ticket text-orange' data-toggle='tooltip' title=''
                                                data-original-title='SD Content!'></i> SD Content
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <span>{{ $leech->created_at->diffForHumans() }}</span>
                                </td>
                                <td>
                                    <span>{{ $leech->getSize() }}</span>
                                </td>
                                <td>
                                    <span>{{ $leech->seeders }}</span>
                                </td>
                                <td>
                                    <span>{{ $leech->leechers }}</span>
                                </td>
                                <td>
                                    <span>{{ $leech->times_completed }}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="dyingtorrents">
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered">
                        <thead>
                        <tr>
                            <th class="torrents-icon"></th>
                            <th class="torrents-filename">@lang('torrent.name')</th>
                            <th>@lang('torrent.age')</th>
                            <th>@lang('torrent.size')</th>
                            <th>@lang('torrent.short-seeds')</th>
                            <th>@lang('torrent.short-leechs')</th>
                            <th>@lang('torrent.short-completed')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($dying as $d)
                            <tr>
                                <td>
                                    @if ($d->category->image != null)
                                        <a href="{{ route('category', ['slug' => $d->category->slug, 'id' => $d->category->id]) }}">
                                            <div class="text-center">
                                                <img src="{{ url('files/img/' . $d->category->image) }}" data-toggle="tooltip"
                                                     data-original-title="{{ $d->category->name }} {{ strtolower(trans('torrent.torrent')) }}"
                                                     style="padding-bottom: 6px;" alt="{{ $d->category->name }}">
                                            </div>
                                        </a>
                                    @else
                                        <a href="{{ route('category', ['slug' => $d->category->slug, 'id' => $d->category->id]) }}">
                                            <div class="text-center">
                                                <i class="{{ $d->category->icon }} torrent-icon" data-toggle="tooltip"
                                                   data-original-title="{{ $d->category->name }} {{ strtolower(trans('torrent.torrent')) }}"
                                                   style="padding-bottom: 6px;"></i>
                                            </div>
                                        </a>
                                    @endif
                                    <div class="text-center">
                                        <span class="label label-success" data-toggle="tooltip" data-original-title="Type">
                                            {{ $d->type }}
                                        </span>
                                    </div>
                                 </td>

                                <td>
                                    <a class="text-bold" href="{{ route('torrent', ['slug' => $d->slug, 'id' => $d->id]) }}">
                                        {{ $d->name }}
                                    </a>
                                    @if (config('torrent.download_check_page') == 1)
                                        <a href="{{ route('download_check', ['slug' => $d->slug, 'id' => $d->id]) }}">
                                            <button class="btn btn-primary btn-circle" type="button" data-toggle="tooltip"
                                                    data-original-title="@lang('common.download')">
                                                <i class="{{ config('other.font-awesome') }} fa-download"></i>
                                            </button>
                                        </a>
                                    @else
                                        <a href="{{ route('download', ['slug' => $d->slug, 'id' => $d->id]) }}">
                                            <button class="btn btn-primary btn-circle" type="button" data-toggle="tooltip"
                                                    data-original-title="@lang('common.download')">
                                                <i class="{{ config('other.font-awesome') }} fa-download"></i>
                                            </button>
                                        </a>
                                    @endif

                                    <span data-toggle="tooltip" data-original-title="@lang('torrent.bookmark')" custom="dyingTorrentBookmark{{ $d->id }}" id="dyingTorrentBookmark{{ $d->id }}" torrent="{{ $d->id }}" state="{{ $bookmarks->where('torrent_id', $d->id)->count() ? 1 : 0}}" class="torrentBookmark"></span>

                                    <br>
                                    @if ($d->anon == 1)
                                        <span class="badge-extra text-bold">
                                        <i class="{{ config('other.font-awesome') }} fa-upload" data-toggle="tooltip" data-original-title="Uploaded By"></i> @lang('common.anonymous')
                                            @if ($user->id == $d->user->id || $user->group->is_modo)
                                                <a href="{{ route('profile', ['username' => $d->user->username, 'id' => $d->user->id]) }}">
                                                    ({{ $d->user->username }})
                                                </a>
                                            @endif
                                        </span>
                                    @else
                                        <span class="badge-extra text-bold">
                                        <i class="{{ config('other.font-awesome') }} fa-upload" data-toggle="tooltip" data-original-title="Uploaded By"></i> By
                                            <a href="{{ route('profile', ['username' => $d->user->username, 'id' => $d->user->id]) }}">
                                                {{ $d->user->username }}
                                            </a>
                                        </span>
                                    @endif

                                    <span class="badge-extra text-bold text-pink">
                                        <i class="{{ config('other.font-awesome') }} fa-heart" data-toggle="tooltip" data-original-title="Thanks Given"></i>
                                        {{ $d->thanks_count }}
                                    </span>

                                    <span class="badge-extra text-bold text-green">
                                        <i class="{{ config('other.font-awesome') }} fa-comment" data-toggle="tooltip" data-original-title="Comments Left"></i>
                                        {{ $d->comments_count }}
                                    </span>

                                    @if ($d->internal == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-magic' data-toggle='tooltip' title=''
                                                data-original-title='Internal Release' style="color: #baaf92;"></i> Internal
                                        </span>
                                    @endif

                                    @if ($d->stream == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-play text-red' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.stream-optimized')'></i> @lang('torrent.stream-optimized')
                                        </span>
                                    @endif

                                    @if ($d->featured == 0)
                                    @if ($d->doubleup == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-gem text-green' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.double-upload')'></i> @lang('torrent.double-upload')
                                        </span>
                                    @endif
                                    @if ($d->free == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-star text-gold' data-toggle='tooltip' title=''
                                                data-original-title='@lang('common.free')'></i> @lang('common.free')
                                        </span>
                                    @endif
                                    @endif

                                    @if ($personal_freeleech)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-id-badge text-orange' data-toggle='tooltip' title=''
                                                data-original-title='Personal FL'></i> Personal FL
                                        </span>
                                    @endif

                                    @if ($freeleech_tokens->where('torrent_id', $d->id)->count())
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-star text-bold' data-toggle='tooltip' title=''
                                                data-original-title='Freeleech Token'></i> Freeleech Token
                                        </span>
                                    @endif

                                    @if ($d->featured == 1)
                                        <span class='badge-extra text-bold' style='background-image:url(/img/sparkels.gif);'>
                                            <i class='{{ config("other.font-awesome") }} fa-certificate text-pink' data-toggle='tooltip' title=''
                                               data-original-title='@lang('torrent.feature')'></i> @lang('torrent.feature')
                                        </span>
                                    @endif

                                    @if ($user->group->is_freeleech == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-trophy text-purple' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.special-freeleech')'></i> @lang('torrent.special-freeleech')
                                        </span>
                                    @endif

                                    @if (config('other.freeleech') == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-globe text-blue' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.global-freeleech')'></i> @lang('torrent.global-freeleech')
                                        </span>
                                    @endif

                                    @if (config('other.doubleup') == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-globe text-green' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.global-double-upload')'></i> @lang('torrent.global-double-upload')
                                        </span>
                                    @endif

                                    @if ($d->leechers >= 5)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-fire text-orange' data-toggle='tooltip' title=''
                                                data-original-title='@lang('common.hot')'></i> @lang('common.hot')
                                        </span>
                                    @endif

                                    @if ($d->sticky == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-thumbtack text-black' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.sticky')'></i> @lang('torrent.sticky')
                                        </span>
                                    @endif

                                    @if ($user->updated_at->getTimestamp() < $d->created_at->getTimestamp())
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-magic text-green' data-toggle='tooltip' title=''
                                                data-original-title='@lang('common.new')'></i> @lang('common.new')
                                        </span>
                                    @endif

                                    @if ($d->highspeed == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-tachometer text-red' data-toggle='tooltip' title=''
                                                data-original-title='@lang('common.high-speeds')'></i> @lang('common.high-speeds')
                                        </span>
                                    @endif

                                    @if ($d->sd == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-ticket text-orange' data-toggle='tooltip' title=''
                                                data-original-title='SD Content!'></i> SD Content
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <span>{{ $d->created_at->diffForHumans() }}</span>
                                </td>
                                <td>
                                    <span>{{ $d->getSize() }}</span>
                                </td>
                                <td>
                                    <span>{{ $d->seeders }}</span>
                                </td>
                                <td>
                                    <span>{{ $d->leechers }}</span>
                                </td>
                                <td>
                                    <span>{{ $d->times_completed }}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="deadtorrents">
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered">
                        <thead>
                        <tr>
                            <th class="torrents-icon"></th>
                            <th class="torrents-filename">@lang('torrent.name')</th>
                            <th>@lang('torrent.age')</th>
                            <th>@lang('torrent.size')</th>
                            <th>@lang('torrent.short-seeds')</th>
                            <th>@lang('torrent.short-leechs')</th>
                            <th>@lang('torrent.short-completed')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($dead as $d)
                            <tr>
                                <td>
                                    @if ($d->category->image != null)
                                        <a href="{{ route('category', ['slug' => $d->category->slug, 'id' => $d->category->id]) }}">
                                            <div class="text-center">
                                                <img src="{{ url('files/img/' . $d->category->image) }}" data-toggle="tooltip"
                                                     data-original-title="{{ $d->category->name }} {{ strtolower(trans('torrent.torrent')) }}"
                                                     style="padding-bottom: 6px;" alt="{{ $d->category->name }}">
                                            </div>
                                        </a>
                                    @else
                                        <a href="{{ route('category', ['slug' => $d->category->slug, 'id' => $d->category->id]) }}">
                                            <div class="text-center">
                                                <i class="{{ $d->category->icon }} torrent-icon" data-toggle="tooltip"
                                                   data-original-title="{{ $d->category->name }} {{ strtolower(trans('torrent.torrent')) }}"
                                                   style="padding-bottom: 6px;"></i>
                                            </div>
                                        </a>
                                    @endif
                                    <div class="text-center">
                                        <span class="label label-success" data-toggle="tooltip" data-original-title="Type">
                                            {{ $d->type }}
                                        </span>
                                    </div>
                                 </td>

                                <td>
                                    <a class="text-bold" href="{{ route('torrent', ['slug' => $d->slug, 'id' => $d->id]) }}">
                                        {{ $d->name }}
                                    </a>
                                    @if (config('torrent.download_check_page') == 1)
                                        <a href="{{ route('download_check', ['slug' => $d->slug, 'id' => $d->id]) }}">
                                            <button class="btn btn-primary btn-circle" type="button" data-toggle="tooltip"
                                                    data-original-title="@lang('common.download')">
                                                <i class="{{ config('other.font-awesome') }} fa-download"></i>
                                            </button>
                                        </a>
                                    @else
                                        <a href="{{ route('download', ['slug' => $d->slug, 'id' => $d->id]) }}">
                                            <button class="btn btn-primary btn-circle" type="button" data-toggle="tooltip"
                                                    data-original-title="@lang('common.download')">
                                                <i class="{{ config('other.font-awesome') }} fa-download"></i>
                                            </button>
                                        </a>
                                    @endif

                                    <span data-toggle="tooltip" data-original-title="@lang('torrent.bookmark')" custom="deadTorrentBookmark{{ $d->id }}" id="deadTorrentBookmark{{ $d->id }}" torrent="{{ $d->id }}" state="{{ $bookmarks->where('torrent_id', $d->id)->count() ? 1 : 0}}" class="torrentBookmark"></span>

                                    <br>
                                    @if ($d->anon == 1)
                                        <span class="badge-extra text-bold">
                                        <i class="{{ config('other.font-awesome') }} fa-upload" data-toggle="tooltip" data-original-title="Uploaded By"></i> @lang('common.anonymous')
                                            @if ($user->id == $d->user->id || $user->group->is_modo)
                                                <a href="{{ route('profile', ['username' => $d->user->username, 'id' => $d->user->id]) }}">
                                                    ({{ $d->user->username }})
                                                </a>
                                            @endif
                                        </span>
                                    @else
                                        <span class="badge-extra text-bold">
                                        <i class="{{ config('other.font-awesome') }} fa-upload" data-toggle="tooltip" data-original-title="Uploaded By"></i> By
                                            <a href="{{ route('profile', ['username' => $d->user->username, 'id' => $d->user->id]) }}">
                                                {{ $d->user->username }}
                                            </a>
                                        </span>
                                    @endif

                                    <span class="badge-extra text-bold text-pink">
                                        <i class="{{ config('other.font-awesome') }} fa-heart" data-toggle="tooltip" data-original-title="Thanks Given"></i>
                                        {{ $d->thanks_count }}
                                    </span>

                                    <span class="badge-extra text-bold text-green">
                                        <i class="{{ config('other.font-awesome') }} fa-comment" data-toggle="tooltip" data-original-title="Comments Left"></i>
                                        {{ $d->comments_count }}
                                    </span>

                                    @if ($d->internal == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-magic' data-toggle='tooltip' title=''
                                                data-original-title='Internal Release' style="color: #baaf92;"></i> Internal
                                        </span>
                                    @endif

                                    @if ($d->stream == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-play text-red' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.stream-optimized')'></i> @lang('torrent.stream-optimized')
                                        </span>
                                    @endif

                                    @if ($d->featured == 0)
                                    @if ($d->doubleup == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-gem text-green' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.double-upload')'></i> @lang('torrent.double-upload')
                                        </span>
                                    @endif
                                    @if ($d->free == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-star text-gold' data-toggle='tooltip' title=''
                                                data-original-title='@lang('common.free')'></i> @lang('common.free')
                                        </span>
                                    @endif
                                    @endif

                                    @if ($personal_freeleech)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-id-badge text-orange' data-toggle='tooltip' title=''
                                                data-original-title='Personal FL'></i> Personal FL
                                        </span>
                                    @endif

                                    @if ($freeleech_tokens->where('torrent_id', $d->id)->count())
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-star text-bold' data-toggle='tooltip' title=''
                                                data-original-title='Freeleech Token'></i> Freeleech Token
                                        </span>
                                    @endif

                                    @if ($d->featured == 1)
                                        <span class='badge-extra text-bold' style='background-image:url(/img/sparkels.gif);'>
                                            <i class='{{ config("other.font-awesome") }} fa-certificate text-pink' data-toggle='tooltip' title=''
                                               data-original-title='@lang('torrent.feature')'></i> @lang('torrent.feature')
                                        </span>
                                    @endif

                                    @if ($user->group->is_freeleech == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-trophy text-purple' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.special-freeleech')'></i> @lang('torrent.special-freeleech')
                                        </span>
                                    @endif

                                    @if (config('other.freeleech') == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-globe text-blue' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.global-freeleech')'></i> @lang('torrent.global-freeleech')
                                        </span>
                                    @endif

                                    @if (config('other.doubleup') == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-globe text-green' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.global-double-upload')'></i> @lang('torrent.global-double-upload')
                                        </span>
                                    @endif

                                    @if ($d->leechers >= 5)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-fire text-orange' data-toggle='tooltip' title=''
                                                data-original-title='@lang('common.hot')'></i> @lang('common.hot')
                                        </span>
                                    @endif

                                    @if ($d->sticky == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-thumbtack text-black' data-toggle='tooltip' title=''
                                                data-original-title='@lang('torrent.sticky')'></i> @lang('torrent.sticky')
                                        </span>
                                    @endif

                                    @if ($user->updated_at->getTimestamp() < $d->created_at->getTimestamp())
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-magic text-green' data-toggle='tooltip' title=''
                                                data-original-title='@lang('common.new')'></i> @lang('common.new')
                                        </span>
                                    @endif

                                    @if ($d->highspeed == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-tachometer text-red' data-toggle='tooltip' title=''
                                                data-original-title='@lang('common.high-speeds')'></i> @lang('common.high-speeds')
                                        </span>
                                    @endif

                                    @if ($d->sd == 1)
                                        <span class='badge-extra text-bold'>
                                            <i class='{{ config("other.font-awesome") }} fa-ticket text-orange' data-toggle='tooltip' title=''
                                                data-original-title='SD Content!'></i> SD Content
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <span>{{ $d->created_at->diffForHumans() }}</span>
                                </td>
                                <td>
                                    <span>{{ $d->getSize() }}</span>
                                </td>
                                <td>
                                    <span>{{ $d->seeders }}</span>
                                </td>
                                <td>
                                    <span>{{ $d->leechers }}</span>
                                </td>
                                <td>
                                    <span>{{ $d->times_completed }}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
