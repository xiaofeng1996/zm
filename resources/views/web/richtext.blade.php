<!DOCTYPE html>
<html>

<head>
	<title>图文详情</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		#wrap {text-align: center}
		#wrap .empty {
			fint-size: 12px;
			color: #99A9BF;

            display: inline-block;
			margin-top: 20px;
		}
	</style>
</head>

<body>
	<div id="wrap">
		@if ($content)
			{!! $content !!}
		@else
			<span class="empty">暂未添加详情</span>
		@endif

	</div>
</body>

</html>