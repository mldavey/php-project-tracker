<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title></title>
</head>
<body>
	<h1>Welcome <?php echo htmlspecialchars($name); ?></h1>
	<p>Hello from the view!</p>
	<?php foreach ($colors as $color): ?>
		<p><?php echo htmlspecialchars($color); ?></p>
	<?php endforeach; ?>
</body>
</html>