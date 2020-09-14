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
                              navbar: ["open", "download"],
                              files  : [
                                'open', 'quicklook', '|', 'download'
                              ],
                               cwd: [],
                          },
                          // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options-2.1#ui
                          // Removes Places
                          ui: ['toolbar', 'tree', 'path', 'stat'],
                          uiOptions: {
                              // toolbar configuration
                              toolbar: [
                                  // ['back', 'forward'],
                                  // ['mkdir', 'mkfile', 'upload','permission'],
                                  // ['open', 'download', 'getfile'],
                                  // ['quicklook'],
                                  // ['copy', 'paste'],
                                  // ['rm'],
                                  // ['duplicate', 'rename', 'edit'],
                                  // ['extract', 'archive'],
                                  // ['search'],
                                  // ['view'],
                                  // ['info'],
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
.elfinder-button-icon-sharedfolder{
   background: blue!important;
}
</style>


</body>
</html>
