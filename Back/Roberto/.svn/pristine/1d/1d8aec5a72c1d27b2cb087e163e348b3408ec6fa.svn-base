var uploadFile = {}
uploadFile.fileInitialVal = '';
uploadFile.leftCorrection = -325;
uploadFile.topCorrection = -10;
uploadFile.ref = '';
uploadFile.status = '';
uploadFile.id = '';
uploadFile.path = '';
uploadFile.error = '';
uploadFile.instanceId = '';

$(document).ready( 
        function(e) 
        { 
                var GETref = uploadFile.GET()['ref'];
                if(typeof(GETref)!='undefined')
                    $('#ref').val(GETref);
                var GETinstanceId = uploadFile.GET()['instanceId'];
                if(typeof(GETref)!='undefined')
                    $('#instanceId').val(GETinstanceId);
                
                uploadFile.instanceId = $('#instanceId').val();
                uploadFile.ref = $('#ref').val();
                uploadFile.status = $('#status').val();
                uploadFile.id = $('#id').val();
                uploadFile.name = $('#name').val();
                uploadFile.originalName = $('#originalName').val();
                uploadFile.url = $('#url').val();
                uploadFile.type = $('#type').val();
                uploadFile.size = $('#size').val();
                uploadFile.width = $('#width').val();
                uploadFile.height = $('#height').val();
                uploadFile.error = $('#error').val();
                
                if (navigator.appVersion.indexOf("Mac")!=-1)
                {
                        uploadFile.leftCorrection = -25;
                        uploadFile.topCorrection = -10;
                }
                else
                        if (navigator.userAgent.toLowerCase().indexOf('chrome')!=-1)
                        {
                                uploadFile.leftCorrection = -25;
                                uploadFile.topCorrection = -10;
                        }

                uploadFile.fileInitialVal = $('#file').val();
                $('#file').val(uploadFile.fileInitialVal);

                if(uploadFile.status=='error'){
                        if(typeof(parent.FileManager.fileUploadingError)!='undefined'){
                            parent.FileManager.fileUploadingError(uploadFile.instanceId, uploadFile.ref, uploadFile.error);
                        }
                        else{
                            alert('Debe definir un método fileUploadError(path, option) en el parent');
                        }
                }
                else{
                    if(uploadFile.status=='ok'){
                        if(typeof(parent.FileManager.fileUploaded)!='undefined'){
                            parent.FileManager.fileUploaded(uploadFile.instanceId, uploadFile.ref, uploadFile.id, uploadFile.name, uploadFile.originalName, uploadFile.url, uploadFile.type, uploadFile.size, uploadFile.width, uploadFile.height);
                        }
                        else{
                            alert('Debe definir un método fileUploaded(path, option) en el parent');
                        }
                    }
                }
        });

$(document).bind('mousemove', 
    function(e) 
    { 
            $('#floatingBrowserDiv').css('left',(e.pageX+uploadFile.leftCorrection)+'px');
            $('#floatingBrowserDiv').css('top',(e.pageY+uploadFile.topCorrection)+'px');
    });

$(document).on({
    'change':function(){
        $('#originalName').val($(this).val());
        uploadFile.submitForm();
    }
},'#file');

uploadFile.submitForm = function() {
        if(typeof(parent.FileManager.fileUploading)!='undefined'){
            parent.FileManager.fileUploading(uploadFile.instanceId, uploadFile.ref);
        }
        else{
            alert('Debe definir un método fileUploading(option) en el parent');
        }
        $('#uploadFileForm').submit();
};

uploadFile.GET = function() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
};

