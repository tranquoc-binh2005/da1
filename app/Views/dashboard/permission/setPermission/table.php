<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Upvex</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                    <li class="breadcrumb-item active">Basic Tables</li>
                </ol>
            </div>
            <h4 class="page-title"><?=$title ?? ""?></h4>
        </div>
    </div>
</div>
<div class="card-box">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
            <tr>
                <th>Tên</th>
                <th class="text-left">Canonical</th>
                <th class="text-center">#</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($roles['data'] as $role) {?>
                <tr>
                    <td class="col-info text-left" width="350px">
                        Tên nhóm: <?=$role['name']?> <br>
                        Người tạo: <?=$role['admin']?>
                    </td>
                    <td class="col-info text-left" width="350px">
                        Tên nhóm: <?=$role['canonical']?>
                    </td>
                    <th class="text-center">
                        <a style="font-size: 20px;" href="/dashboard/permissions/setPermission/<?=$role['id']?>"><i class="fe-unlock"></i></a>
                    </th>
                </tr>
                <tr>
                </tr>
            <?php }?>
            </tbody>
        </table>

        <?php include 'paginate.php' ?>

    </div>
</div>
