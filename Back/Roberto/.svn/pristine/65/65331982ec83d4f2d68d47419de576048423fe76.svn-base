<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<head>
		<script type="text/javascript" src="/js/jquery/jquery.js"></script>
		<script type="text/javascript" src="/js/uploadFile.js"></script>
                <link href="/css/uploadFile.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>		
		<div id="floatingBrowserDiv" class="floatingDiv" >
			<form enctype="multipart/form-data" id="uploadFileForm" name="uploadImageForm" method="post" action="/Files/uploadFile">
                                <input type="hidden" id="status" value="<?php echo $status; ?>"/>
                                <input type="hidden" id="id" value="<?php echo HelperFunctions::purify($file->id); ?>"/>
                                <input type="hidden" id="name" value="<?php echo HelperFunctions::purify($file->name); ?>"/>
                                <input type="hidden" id="originalName" value="<?php echo HelperFunctions::purify($file->original_name); ?>" name="originalName"/>
                                <input type="hidden" id="url" value="<?php echo HelperFunctions::purify($file->url); ?>"/>
                                <input type="hidden" id="type" value="<?php echo HelperFunctions::purify($file->file_type_id); ?>"/>
                                <input type="hidden" id="size" value="<?php echo HelperFunctions::purify($file->size); ?>"/>
                                <input type="hidden" id="width" value="<?php echo HelperFunctions::purify($file->width); ?>"/>
                                <input type="hidden" id="height" value="<?php echo HelperFunctions::purify($file->height); ?>"/>
                                <input type="hidden" id="ref" value="<?php echo HelperFunctions::purify($file->ref); ?>" name="ref" />
                                <input type="hidden" id="instanceId" value="<?php echo HelperFunctions::purify($instanceId); ?>" name="instanceId" />
                                <input type="hidden" id="error" value="<?php echo HelperFunctions::purify($error); ?>"/>
				<input id="ytFiles_image" type="hidden" value=""/>
				<input type="file" name="Files[file]" id="file" class="file" size="40" tabindex="0"/>
			</form>			
		</div>
	</body>
</html>