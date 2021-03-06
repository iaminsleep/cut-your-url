<?php 
	require_once 'requires/functions.php';

	if(!$isAuth) {
		session_destroy();
		redirect();
	};

	$sessionUid = $_SESSION['user']['id'];

	$errorMessage = get_messages('error');
	$successMessage = get_messages('success');

	$links = get_user_links($sessionUid);

	$user = db_query("SELECT * FROM `users` WHERE `id` = ".(int)$sessionUid)->fetch();

	$avatar = get_user_avatar($sessionUid);

	include_once 'includes/header_profile.php';
?>
	<main class="container">
		<?php show_alert_messages($errorMessage, $successMessage); ?>
		<div style="margin-top: 30px; display: flex; flex-direction: row;">
			<div>
				<?php if(file_exists("img/avatars/".$avatar) && $avatar !== 'noavatar.png'): ?>
					<form action="actions/delete_avatar.php" method="post">
						<img src="img/avatars/<?php echo $avatar?>" width="256" height="256" style="position: absolute;" alt="Аватар пользователя <?php echo $user['login']?>">
						<button class="btn-close" type="submit" title="Удалить аватар" name="delete_avatar" style="position: absolute; margin-left: 230px;"></button>
					</form>
				<?php else: ?>
					<img src="img/avatars/noavatar.png" width="256" height="256" alt="noavatar" style="position: absolute;">
				<?php endif; ?>
				<form action="actions/upload_avatar.php" method="post" enctype="multipart/form-data" style="margin-top: 300px; display: flex; flex-direction: column">
					<input type="file" name="avatar">
					<button type="submit" name="set_avatar" class="btn btn-primary" style="margin-top: 10px;
		margin-right: 150px;">Загрузить аватар</button>
				</form>
			</div>
			<h3><?php echo $user['login']?></h3>
		</div>
		<div class="row mt-5">
			<?php if(empty($links)) { ?>
				<p class="text-center">Здесь пока что пусто. Создайте свою первую ссылку!</p>
			<?php } else { ?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Ссылка</th>
						<th scope="col">Сокращение</th>
						<th scope="col">Переходы</th>
						<th scope="col">Действия</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($links as $index => $link): ?>
						<tr>
							<th scope="row"><?php echo $index + 1?></th> <!-- +1 нужен т.к элементы в массиве начинаются с нуля -->
							<td><?php echo $link['long_link']?></td>
							<td class="short-link"><a href="<?php echo $link['short_link']?>" target="_blank"><?php echo get_url($link['short_link'])?></a></td>
							<td><?php echo $link['views']?></td>
							<td>
								<button class="btn btn-primary btn-sm copy-btn" title="Скопировать в буфер" data-clipboard-text="<?php echo get_url($link['short_link'])?>"><i class="bi bi-files"></i></button>
								<a href="<?php echo get_url("edit-link.php?link=".$link['short_link'])?>" class="btn btn-warning btn-sm" title="Редактировать"><i class="bi bi-pencil"></i></a>
								<a href="<?php echo get_url("actions/delete_link.php?id=".(int)$link['id'])?>" class="btn btn-danger btn-sm" title="Удалить"><i class="bi bi-trash"></i></a>
							</td>
						</tr>
					<?php endforeach; }?>
				</tbody>
			</table>
		</div>
	</main>
	<?php include 'includes/toast.php'; ?>
<?php include 'includes/footer_profile.php';?>