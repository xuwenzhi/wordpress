<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Visual Website Editor</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<style>
body {
	font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
	font-size: 14px;
}
</style>
</head>

<body>

<?php if($view['mode']=='redirect'){ ?>

<p id="redirect-status">Redirect...</p>

<script> location.href = "<?php echo $view['url_redirect'] ?>"; </script>

<?php } ?>

<?php if($view['mode']=='loading'){ ?>

<p id="loading-status">Loading...</p>

<script> 

var url_access = "<?php echo $view['url_access'] ?>";

var url_source = '<?php echo get_site_url() ?>';

//

function onError(){
	$("#loading-status").html('Something goes wrong, please try again!');
}

function onSuccess(e){
	location.href = url_source + '/wp-admin/admin-ajax.php?action=visual_editor_redirect&' + 
	'mode=update_access_data&private_key='+e.private_key+'&public_key='+e.public_key+'&access_key='+e.access_key;
}

$.getJSON(url_access, function(data){
	
	if(!data || !data.status){
		onFail();
		return false;
	}
	
	onSuccess(data.value);
	
}).fail(function(){
	
	onFail();
	
});

</script>

<?php } ?>

</body>
</html>