<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="#">Dashboard</a>
		</li>
		<li class="breadcrumb-item active"><?= lang('General.categories') ?></li>
	</ol>

	<div class="my-4">
		<a class="btn btn-primary btn-block" href="/admin/categories/new"><?= lang('General.add') ?></a>
	</div>

<!-- DataTables Example -->
<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-user-friends"></i>
			<?= lang('General.categories') ?></div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="teams-table" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th><?= lang('General.id') ?></th>
							<th><?= lang('General.name') ?></th>
							<th><?= lang('General.description') ?></th>
							<th><?= lang('General.createdAt') ?></th>
							<th><?= lang('General.updatedAt') ?></th>
							<th><?= lang('General.detail') ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($categories as $cat): ?>
						<tr>
							<td><?= esc($cat["id"]) ?></td>
							<td><?= esc($cat["name"]) ?></td>
							<td><?= esc($cat["description"]) ?></td>
							<td><?= esc($cat["created_at"]) ?></td>
							<td><?= esc($cat["updated_at"]) ?></td>
							<td>
								<a class="btn btn-info btn-block" href="/admin/categories/<?= esc($cat["id"]) ?>">
									<?= lang('General.detail') ?>
								</a>
							</td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			$("#teams-table").DataTable();
		});
	</script>
<?= $this->endSection() ?>