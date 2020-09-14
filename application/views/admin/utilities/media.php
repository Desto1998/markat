<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head();
?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
            <div id="elfinder"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/elFinder/themes/Material/css/theme-gray.css?v='.get_app_version()); ?>">
<?php init_tail(); ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/require.js/2.3.2/require.min.js"></script>
<script>
define('elFinderConfig', {
      // elFinder options (REQUIRED)
      // Documentation for client options:
      // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
      defaultOpts: {
          url: '<?php echo $connector ?>' // connector URL (REQUIRED)
              ,
          commandsOptions: {
              edit: {
                  extraOptions: {
                      // set API key to enable Creative Cloud image editor
                      // see https://console.adobe.io/
                      creativeCloudApiKey: '',
                      // browsing manager URL for CKEditor, TinyMCE
                      // uses self location with the empty value
                      managerUrl: ''
                  }
              },
              quicklook: {
                  // to enable preview with Google Docs Viewer
                  googleDocsMimes: ['application/pdf', 'image/tiff', 'application/vnd.ms-office', 'application/msword', 'application/vnd.ms-word', 'application/vnd.ms-excel', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
              }
          }
          // bootCalback calls at before elFinder boot up
          ,
          bootCallback: function(fm, extraObj) {
              /* any bind functions etc. */
              fm.bind('init', function() {
                  // any your code
              });
              // for example set document.title dynamically.
              var title = document.title;
              fm.bind('open', function() {
                  var path = '',
                      cwd = fm.cwd();
                  if (cwd) {
                      path = fm.path(cwd.hash) || null;
                  }
                  document.title = path ? path + ':' + title : title;
              }).bind('destroy', function() {
                  document.title = title;
              });
          }
      },
      managers: {
          // 'DOM Element ID': { /* elFinder options of this DOM Element */ }
          'elfinder': {}
      }
  });
  define('returnVoid', void 0);
  (function() {
      var // elFinder version
          elver = '<?php echo elFinder::getApiFullVersion()?>',
          // jQuery and jQueryUI version
          jqver = '3.2.1',
          uiver = '1.12.1',
          // Start elFinder (REQUIRED)
          start = function(elFinder, editors, config) {
              // load jQueryUI CSS
              elFinder.prototype.loadCss('//cdnjs.cloudflare.com/ajax/libs/jqueryui/' + uiver + '/themes/smoothness/jquery-ui.css');

              $(function() {
                  var elfEditorCustomData = {};
                  if (typeof(csrfData) !== 'undefined') {
                      elfEditorCustomData[csrfData['token_name']] = csrfData['hash'];
                  }
                  var optEditors = {
                          commandsOptions: {
                              edit: {
                                  editors: Array.isArray(editors) ? editors : []
                              }
                          }
                      },
                      opts = {
                          height: 700,
                          customData: elfEditorCustomData,
                          contextmenu : {
                            navbar: ["open", "opennew", "download", "|", "upload", "mkdir", "|", "copy", "cut", "paste", "duplicate", "|", "rm", "empty", "hide", "|", "rename", "|", "archive", "|", "places", "info", "chmod", "netunmount","sharedfolder"],
                              files  : [
                                'getfile', '|','open', 'quicklook', '|', 'download', '|', 'copy', 'cut', 'paste', 'duplicate', '|',
                                'rm', '|', 'edit', 'rename', '|', 'archive', 'extract',"sharedfolder"
                              ]
                          },
                          // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options-2.1#ui
                          // Removes Places
                          ui: ['toolbar', 'tree', 'path', 'stat'],
                          uiOptions: {
                              // toolbar configuration
                              toolbar: [
                                  ['back', 'forward'],
                                  ['mkdir', 'mkfile', 'upload','permission'],
                                  ['open', 'download', 'getfile'],
                                  ['quicklook'],
                                  ['copy', 'paste'],
                                  ['rm'],
                                  ['duplicate', 'rename', 'edit'],
                                  ['extract', 'archive'],
                                  ['search'],
                                  ['view'],
                                  ['info'],
                              ],

                          }
                      };
                  // Interpretation of "elFinderConfig"
                  if (config && config.managers) {
                      $.each(config.managers, function(id, mOpts) {
                          opts = Object.assign(opts, config.defaultOpts || {});
                          // editors marges to opts.commandOptions.edit
                          try {
                              mOpts.commandsOptions.edit.editors = mOpts.commandsOptions.edit.editors.concat(editors || []);
                          } catch (e) {
                              Object.assign(mOpts, optEditors);
                          }
                          // Make elFinder
                          $('#' + id).elfinder(
                              // 1st Arg - options
                              $.extend(true, {
                                  lang: '<?php echo get_media_locale($locale); ?>'
                              }, opts, mOpts || {}),
                              // 2nd Arg - before boot up function
                              function(fm, extraObj) {
                                  // `init` event callback function
                                  fm.bind('init', function() {

                                  });
                              }
                          );
                      });
                  } else {
                      console.error('"elFinderConfig" object is wrong.');
                  }
              });
          },
          // JavaScript loader (REQUIRED)
          load = function() {
              require(
                  [
                      'elfinder',
                      'extras/editors.default', // load text, image editors
                      'elFinderConfig'
                      //  , 'extras/quicklook.googledocs'  // optional preview for GoogleApps contents on the GoogleDrive volume
                  ],
                  start,
                  function(error) {
                      alert(error.message);
                  }
              );
          },
          // is IE8? for determine the jQuery version to use (optional)
          ie8 = (typeof window.addEventListener === 'undefined' && typeof document.getElementsByClassName === 'undefined');

          // config of RequireJS (REQUIRED)
          require.config({
              baseUrl: site_url + 'assets/plugins/elFinder/js',
              paths: {
                  'jquery': '//cdnjs.cloudflare.com/ajax/libs/jquery/' + (ie8 ? '1.12.4' : jqver) + '/jquery.min',
                  'jquery-ui': '//cdnjs.cloudflare.com/ajax/libs/jqueryui/' + uiver + '/jquery-ui.min',
                  'elfinder': 'elfinder.min',
                //  'encoding-japanese': '//cdn.rawgit.com/polygonplanet/encoding.js/master/encoding.min'
              },
              waitSeconds: 10 // optional
          });
        // load JavaScripts (REQUIRED)
        load();
  })();
  $(document).ready(function() {
        $("#folderbutton").click(function(){
            var favorite = [];

            var elfinderdir = $('#elfinderdir').val();
            var elfindername = $('#elfindername').val();
            $.each($("input[name='users']:checked"), function(){
                favorite.push($(this).val());
            });
            //alert("My favourite sports are: " + favorite.join(", "));
             $.post(admin_url + 'utilities/user_permission', {users_id: favorite.join(", "),elfinderdir:elfinderdir,elfindername:elfindername}, function(result){
             //alert(result)
                if(result == "1"){
                  alert_float('success', "Permission provided user successfully");
                  setTimeout(function() {
       location.reload(true)

    }, 3000);
                }else{
                  alert_float('warning', 'Permission not provided user')
                }
            });


        });
    });






</script>



<style>
.elfinder-button-icon-permission:before{
 /* background: red!important;*/
/*  content: '\e81f'!important;*/
 }
 .elfinder-button-icon-permission:after{
  /*background: red!important;*/
  /*content: '\e81f'!important;*/
 }
.elfinder-button-icon-permission{
   background: red!important;
}
</style>


 <div class="modal fade" id="newoccupation" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span
                                                    aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">
                                           Folder Permission
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <input type="hidden" id="elfinderdir">
                                            <input type="hidden" id="elfindername">

                                          <h3>Select Users</h3>
                                         <!--  <div class="row"> -->


                                          <?php if(!empty($staff_members)) {
                                            foreach($staff_members as $staff_member){ ?>
                                              <!-- <div class="col-md-3"> -->
                                          <label><input type="checkbox" value="<?php echo $staff_member['staffid']; ?>" name="users"> <?php echo $staff_member['firstname'],' '.$staff_member['lastname']; ?></label>
                                        <!--   </div> -->
                                          <?php }}?>

                                         <!--  </div> -->
                                          <br>
                                          <button type="button" class="btn btn-info" id="folderbutton">Set Permission</button>
                                      </form>
                                    </div>
                                </div>
                            </div>
                        </div>


  <div class="modal fade" id="sharedlinkmodel" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span
                                                    aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">
                                           Share Link
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                    <div class="">


                                     <div class="row">
                                        <div class="col-sm-9">

                                            <input type="text" class="form-control" readonly id="sharelink"  value="">
                                            <input type="hidden" class="form-control" readonly id="sharelink1"  value="<?php echo base_url('/admin/utilities/sharelink/'); ?>">
                                        </div>
                                         <div class="col-sm-3">
                                            <button class="btn btn-info" onclick="myFunction()">Copy text</button>
                                        </div>
                                      </div>
                                      </br>
                                      <div id="response" style="margin-top:5px;"></div>
                                    <?php echo form_open('/admin/utilities/ajax_assign', array('class' => '', 'id' => 'form-media')); ?>
                                     <input type="hidden" id="elfinderdir_new" name="elfinderdir_new">
                                      <div class="row">
                                      <div class="col-sm-12">
                                             <label><input type="checkbox" name="private" value="check" > Private</label>
                                        </div>
                                      </div>
                                      <div class="check box">
                                      <div class="row">
                                      <div class="col-sm-9">

                                              <input type="password" required class="form-control"  id="password" name="password" value="">
                                          </div>
                                          <div class="col-sm-3">
                                          <button  type="submit" class="btn btn-info" id="form_submit">Save</button>
                                           </div>
                                      </div>
                                       </div>
                                         <!--  </div> -->

                                      <?php echo form_close(); ?>


                                      </div>
                                    </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                        function myFunction() {
  /* Get the text field */
  var copyText = document.getElementById("sharelink");

  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); /*For mobile devices*/

  /* Copy the text inside the text field */
  document.execCommand("copy");

  /* Alert the copied text */
  //alert("Copied the text: " + copyText.value);
}
 $(document).ready(function() {
            $('input[type="checkbox"]').click(function() {
                var inputValue = $(this).attr("value");
                $("." + inputValue).toggle();
            });
        });
     appValidateForm($('#form-media'), {password: 'required'});

  var form_id = '#form-media';
 $(function() {
   $(form_id).appFormValidator({

    onSubmit: function(form) {

     var formURL = $(form).attr("action");
     var formData = new FormData($(form)[0]);

     $.ajax({
       type: $(form).attr('method'),
       data: formData,
       contentType: false,
       cache: false,
       processData: false,
       url: formURL
     }).always(function(){
      $('#form_submit').prop('disabled', false);
     }).done(function(response){
      response = JSON.parse(response);
     // alert(JSON.stringify(response))
                 // In case action hook is used to redirect

                 if (response.success == false) {
                     $('#recaptcha_response_field').html(response.message); // error message
                   } else if (response.success == true) {
                     $(form_id).remove();
                     $('#response').html('<div class="alert alert-success">Link has been private</div>');
                     // $('html,body').animate({
                     //   scrollTop: $("#online_payment_form").offset().top
                     // },'slow');
                   } else {
                     $('#response').html('Something went wrong...');
                   }
                   if (typeof(grecaptcha) != 'undefined') {
                     grecaptcha.reset();
                   }
                 }).fail(function(data){
                 if (typeof(grecaptcha) != 'undefined') {
                   grecaptcha.reset();
                 }
                 if(data.status == 422) {
                    $('#response').html('<div class="alert alert-danger">Some fields that are required are not filled properly.</div>');
                 } else {
                    $('#response').html(data.responseText);
                 }
               });
                 return false;
               }
             });
 });
</script>
 <style type="text/css">
        .box {
            color: black;
            display: none;
            margin-top: 20px;
        }

        .check {
            background: #ffffff;
        }
    </style>
</body>
</html>
