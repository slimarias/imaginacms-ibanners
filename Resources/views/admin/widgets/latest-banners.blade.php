<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">{{ trans('ibanners::banner.latest banners') }}</h3>
    </div><!-- /.box-header -->
    <div class="box-body no-padding">
        <table class="table table-striped">
            <tbody><tr>
                <th style="width: 10px">#</th>
                <th>{{ trans('ibanners::banner.table.title') }}</th>
                <th>{{ trans('core::core.table.created at') }}</th>
            </tr>
            <?php if (isset($banners)): ?>
                <?php foreach ($banners as $banner): ?>
                    <tr>
                        <td>{{ $banner->id }}</td>
                        <td>{{ $banner->title }}</td>
                        <td>{{ $banner->created_at }}</td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div><!-- /.box-body -->
</div>
