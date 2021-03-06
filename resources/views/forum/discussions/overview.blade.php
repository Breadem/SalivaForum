@extends('layouts.default')

@push('styles')
    @include('_partials._jumbotron_under_nav_styles')
    <style>
        .sticky-wrapper strong {
            font-weight: normal;
        }
    </style>
@endpush

@section('content')
    <div class="jumbotron">
        <div class="container">
            <p>
                为不拘一格者
                <a class="btn btn-md btn-primary pull-right" href="{{ route('discussions.create') }}" role="button">发布新帖 »</a>
            </p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        @foreach($discussions as $discussion)
                            <div class="media">
                                <div class="media-left media-middle">
                                    <img class="media-object img-circle" src="{{ asset($discussion->user->avatar) }}" alt="64x64"
                                         style="width: 48px; height: 48px;">
                                </div>
                                <div class="media-body" style="font-size: 12px;">
                                    <h3 class="media-heading" style="font-size: 15px;">
                                        <a href="{{ route('discussion', ['id' => $discussion->slug] ) }}"
                                           style="display: block;">
                                            {{ $discussion->title }}
                                        </a>
                                    </h3>
                                    <div class="media-conversation-meta">
                                        <span class="media-conversation-replies">
                                            <a href="{{ route('discussion', ['id' => $discussion->slug] ) }}#post-comments">{{ $discussion->comments_count }}</a>
                                        回复
                                        </span>
                                    </div>
                                    <div class="media-info">
                                        @if(count($discussion->categories) > 0)
                                            @foreach($discussion->categories as $category)
                                                <span class="badge">{{ $category->name }}</span>
                                            @endforeach
                                        @endif
                                        {{ $discussion->user->username }} 发布于 {{ $discussion->created_at->diffForHumans() }}
                                        @if($discussion->user_id !== $discussion->last_user_id)
                                            <i class="icon fa fa-fw fa-reply "></i>
                                            {{ $discussion->lastUser->username }} {{ $discussion->updated_at->diffForHumans() }} 更新
                                        @elseif (!$discussion->updated_at->eq($discussion->created_at))
                                            , 更新于 {{ $discussion->updated_at->diffForHumans() }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-12 text-center">
                        {{ $discussions->links() }}
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="margin-bottom: 1.25rem;">
                <div id="user-ranking" class="panel panel-default sticky-here">
                    <div class="panel-heading text-center">贡献榜</div>
                    <div class="panel-body">
                        @foreach($users as $user)
                            <div class="media" style="padding: 6px 3px;">
                                <div class="media-left media-middle">
                                    <a href="{{ route('profile', [$user->username]) }}">
                                        <img class="media-object img-circle"
                                             src="{{ asset($user->avatar) }}" alt="avatar"
                                             style="width: 32px; height: 32px;">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <span class="media-heading" style="display: block; margin-top: 6px;">
                                        <a href="{{ route('profile.discussions', ['username' => $user->username]) }}" style="display: block;">
                                            <strong>{{ $user->username }}</strong>
                                            <span style="color: #999;">{{ $user->discussions_count }}篇帖</span>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('_partials._sticky_scripts')
@endpush
