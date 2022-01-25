<div class="profile-feed row">
    <div class="col-sm-6">
        @foreach($client->status()->get() as $status)
            <div class="profile-activity clearfix">
                <div>
                    <img class="pull-left" alt="Alex Doe's avatar"
                         src="https://bootdey.com/img/Content/avatar/avatar1.png">
                    <a class="user" href="#"> {{$status}} </a>
                    changed his profile photo.
                    <a href="#">Take a look</a>

                    <div class="time">
                        <i class="ace-icon fa fa-clock-o bigger-110"></i>
                        an hour ago
                    </div>
                </div>

                <div class="tools action-buttons">
                    <a href="#" class="blue">
                        <i class="ace-icon fa fa-pencil bigger-125"></i>
                    </a>

                    <a href="#" class="red">
                        <i class="ace-icon fa fa-times bigger-125"></i>
                    </a>
                </div>
            </div>
        @endforeach

    </div><!-- /.col -->

    <div class="col-sm-6">
        @foreach($client->status()->get() as $status)
            <div class="profile-activity clearfix">
                <div>
                    <i class="pull-left thumbicon fa fa-pencil-square-o btn-pink no-hover"></i>
                    <a class="user" href="#"> Alex Doe </a>
                    published a new blog post.
                    <a href="#">Read now</a>

                    <div class="time">
                        <i class="ace-icon fa fa-clock-o bigger-110"></i>
                        11 hours ago
                    </div>
                </div>

                <div class="tools action-buttons">
                    <a href="#" class="blue">
                        <i class="ace-icon fa fa-pencil bigger-125"></i>
                    </a>

                    <a href="#" class="red">
                        <i class="ace-icon fa fa-times bigger-125"></i>
                    </a>
                </div>
            </div>
        @endforeach

    </div><!-- /.col -->
</div><!-- /.row -->

<div class="space-12"></div>

<div class="center">
    <button type="button" class="btn btn-sm btn-primary btn-white btn-round">
        <i class="ace-icon fa fa-rss bigger-150 middle orange2"></i>
        <span class="bigger-110">View more activities</span>

        <i class="icon-on-right ace-icon fa fa-arrow-right"></i>
    </button>
</div>
