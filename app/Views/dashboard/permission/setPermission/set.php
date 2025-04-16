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
            <?php
            if(isset($errors)){
                foreach ($errors as $error) {
                    foreach ($error as $e) {
                        echo '<div class="text-danger">-' . $e . '</div>';
                    }
                }
            }
            ?>
            <br>
        </div>
    </div>
</div>
<div class="card-box">
    <form action="/dashboard/permissions/savePermission" method="POST">
        <h4>Phần quyền cho nhóm vai trò: <span class="text-danger"><?=$role['name']?></span></h4>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                <tr>
                    <th>Tên modules</th>
                    <th colspan="10" class="text-center">#</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $checkedPermissions = [];

                if (!empty($isPermissionSelected)) {
                    foreach ($isPermissionSelected['data'] as $isSelected) {
                        if ($isSelected['role_id'] == $role['id']) {
                            $checkedPermissions[] = $isSelected['permission_id'];
                        }
                    }
                }
                ?>
                <?php if(empty($permissions)){ ?>
                    <tr>
                        <td class="text-center" colspan="8">Không có bản ghi phù hợp</td>
                    </tr>
                <?php } else { ?>
                    <?php foreach ($permissions as $module => $items) { ?>
                        <tr>
                            <td class="text-left"><strong><?= ucfirst($module) ?></strong></td>
                            <?php foreach ($items as $permission) { ?>
                                <td class="text-left">
                                    <input type="checkbox"
                                           id="permission<?=$permission['id']?>"
                                           name="permission[<?=$role['id']?>][]"
                                           value="<?=$permission['id']?>"
                                        <?= in_array($permission['id'], $checkedPermissions) ? 'checked' : '' ?>
                                    > &nbsp;
                                    <label for="permission<?=$permission['id']?>">
                                        <strong><?= $permission['title'] ?></strong>
                                    </label><br>
                                    <small><?= $permission['description'] ?></small><br>
                                    <input type="hidden" name="role_id" value="<?=$role['id']?>">
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="form-group text-right mb-0">
            <a href="/dashboard/permissions/bulkStore" class="text-white">
                <button type="button" class="btn btn-info waves-effect waves-light">
                    Quay về
                </button></a>
            <button type="submit" class="btn btn-danger waves-effect waves-light">Lưu lại</button>
        </div>
    </form>
</div>