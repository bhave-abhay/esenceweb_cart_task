<?php foreach ($arrScript as $scriptInfo) : ?>
	<script
		src="<?= $scriptInfo['src']?>"
		<?php if(isset($scriptInfo['integrity'])):?>
			integrity="<?= $scriptInfo['integrity']?>"
		<?php endif ?>
		<?php if(isset($scriptInfo['crossorigin'])):?>
			crossorigin="<?= $scriptInfo['crossorigin']?>"
		<?php endif ?>
	>
	</script>
<?php endforeach ?>
<!-- -->

</body>
</html>
