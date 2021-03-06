<?= $this->extend("darky/templates/base") ?>

<?= $this->section('content') ?>

<?php if (user()->team_id === null): ?>
	<div class="alert alert-danger m-2" role="alert">
		<h3 class="alert-heading"><?= lang('Home.watchOut') ?></h3>
		<p><?= lang('Home.findTeamToComp') ?></p>
		<hr>
		<a class="alert-link" href="/team"><?= lang('Home.visitTeamPage') ?></a>
	</div>
<?php endif ?>

<div class="row">
	<div class="col-md-4 my-2">
		<?php foreach ($categories as $category) : ?>
			<?php if (isset($category['challenges']) === true): ?>
				<div class="card border-secondary mb-3">
					<h4 class="card-header"><?= esc($category['name']) ?></h4>
					<div class="list-group list-group-flush">
						<?php foreach ($category['challenges'] as $ch): ?>
							<a href="/challenges/<?= $ch->id ?>" class="list-group-item list-group-item-action p-2 <?= in_array($ch->id, $solves) ? 'text-success':'text-danger' ?>">
								<?= esc($ch->name) ?> (<?= esc($ch->point) ?>)</a>
						<?php endforeach ?>
					</div>
				</div>
			<?php endif ?>
		<?php endforeach ?>
	</div>


	<div class="col-md-8">
		<?php if(isset($challenge)) : ?>
			<div class="card m-2">
				<h3 class="card-header <?= in_array($challenge->id, $solves) ? 'bg-success':'bg-danger' ?>"><?= esc($challenge->name) ?></h3>
				<h3 class="card-title text-center text-info my-2"><?= esc($challenge->point).' '.lang('General.point')?></h3>

				<div class="card-body">
					<p class="card-text lead"><?= esc($challenge->description) ?></p>
				</div>

				<?php if(! empty($files)): ?>
					<div>
						<h4 class="card-title text-center"><?= lang('General.files') ?></h4>
						<ul class="list-group list-group-flush">
							<?php foreach($files as $file): ?>
								<li class="list-group-item text-info">
									
									<a href="/uploads/<?= esc($file['location']) ?>"><?= esc($file['location']) ?></a>
								</li>
							<?php endforeach ?>
						</ul>
					</div>
				<?php endif ?>

				<?php if(! empty($hints)): ?>
					<div class="">
						<?php foreach($hints as $hint): ?>
							<ul class="list-group list-group-flush">
								<?php if(in_array($hint['id'], $hints_unlocks)): ?>
								<li class="list-group-item text-info">
									<?= esc($hint['content']) ?>
								</li>
								<?php else: ?>
								<li class="list-group-item text-info">
									<form action="/challenges/<?= esc($challenge->id) ?>/hints/<?= esc($hint['id']) ?>" method="post">
										<?= csrf_field() ?>
										<button class="btn btn-primary btn-block" type="submit">
											<?= lang('Home.hintUnlock').' ('.$hint['cost'].' '.lang('General.point').')' ?>
										</button>
									</form>
								</li>
								<?php endif ?>
							</ul>
						<?php endforeach ?>
					</div>
				<?php endif ?>

				<div class="card-footer bg-dark">
					<div class="row">
						<div class="col-9 row">
							<div class="col-sm-6 text-danger"><?= lang('Home.firstBlood') ?></div>
							<?php if(! empty($firstblood)): ?>
								<div class="col-sm-6 text-success"><?= esc($firstblood['name']) ?></div>
							<?php endif ?>
						</div>
						<div class="col-3">
							<button class="btn btn-secondary btn-block" data-toggle="modal" data-target="#solvers-modal">
								<?= count($solvers).' '.lang('Home.solves') ?>
							</button>
						</div>
					</div>
				</div>

				<?php if(session()->has('result')): ?>
					<?php if (session('result') === true): ?>
						<div class="alert alert-dismissible alert-success m-2">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<?= lang('Home.rightAnswer') ?>
						</div>
					<?php else: ?>
						<div class="alert alert-dismissible alert-danger m-2">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<?= lang('Home.wrongAnswer') ?>
						</div>
					<?php endif ?>
				<?php endif ?>

				<div class="card-footer text-muted">
					<div class="w-100">
						<form class="" action="/challenges/<?= esc($challenge->id) ?>" method="post">
							<?= csrf_field() ?>
							<div class="form-row">
								<div class="col-9">
									<input type="text" name="flag" class="form-control form-control-lg" placeholder="Flag gir">
									<input type="hidden" name="ch-id">
								</div>
								<div class="col-3">
									<button type="submit" class="btn btn-primary btn-lg btn-block"><?= lang('Home.submit') ?></button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="modal fade" id="solvers-modal">
				<div class="modal-dialog modal-lg modal-dialog-scrollable">
					<div class="modal-content">
						<div class="modal-body">
							<div class="table-responsive">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<table class="table">
									<thead>
										<tr>
											<th scope="col"><?= lang('Home.teamName') ?></th>
											<th scope="col"><?= lang('General.date').' - '.lang('General.time') ?></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($solvers as $solver) : ?>
											<tr>
												<td><?= esc($solver['name']) ?></td>
												<td><?= esc($solver['date']) ?></td>
											</tr>
										<?php endforeach ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endif ?>
	</div>
</div>

<?= $this->endSection() ?>