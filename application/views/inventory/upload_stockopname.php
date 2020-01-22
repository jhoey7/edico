<div class="col-md-12">
	<form id="form_upload_sto" name="form_upload_sto" action="execute/process/read/stockopname" method="post" autocomplete="off" onSubmit="upload_stockopname('form_upload_sto','execute/process/read/stockopname'); return false;" novalidate="novalidate">
		<div class="panel-body">
			<div class="row">
                <div class="form-group">
                    <label class="col-sm-3 control-label">File Upload Stockopname</label>
                    <div class="col-sm-6">
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="input-append">
                                <div class="uneditable-input">
                                    <i class="glyphicon glyphicon-file fileupload-exists"></i>
                                    <span class="fileupload-preview"></span>
                                </div>
                                <span class="btn btn-default btn-file">
                                    <span class="fileupload-new">Select file</span>
                                    <span class="fileupload-exists">Change</span>
                                    <input type="file" name="fileupload" id="fileupload">
                                </span>
                                <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <span style="float: right;"><a href="<?php echo base_url('assets/file/template_upload_stockopname.xlsx'); ?>" target="_blank"><i class="fa fa-link"></i>&nbsp;Download Template File</a></span>
                    </div>
                </div>
                <div class="form-group">
                    <div id="div_html"></div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-sm-5 col-sm-offset-5">
                    <button type="submit" class="btn btn-primary" onclick="upload_stockopname('form_upload_sto','execute/process/read/stockopname'); return false;">Submit</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                </div>
            </div>
        </div>
    </form>
</div>
<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-fileupload.min.css'); ?>" />
<script src="<?php echo base_url('assets/js/bootstrap-fileupload.min.js'); ?>"></script>
<script>
function upload_stockopname(form,url){
    if(validasi(form)){
        var arrform = new FormData(document.getElementById(form));
        $.ajax({
            type: 'POST',
            url : site_url+'/'+url,
            data: arrform,
            dataType : 'json',
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function(){Loading(true)},
            complete: function(){Loading(false)},
            success: function(data){
                $('#div_html').html(data.message);
                if (data.status == "success"){
                    setTimeout(function(){ 
                        jpopup_close();
                        $('#divtblstockopname').load(data._url); 
                    }, 3000);
                }
            }
        }); 
    }
}
</script>