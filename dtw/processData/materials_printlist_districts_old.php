<?php
if (isset($_POST['advanced_search_table'])) {

                  $myArray = json_decode($_POST['filters']);

                  $myArray = join("', '", $myArray);

                  $searchQuery = "SELECT * FROM schools WHERE division_name IN ('$myArray')";
                  $result_set = mysql_query($searchQuery);
                } else {
                  $resultSQL = "SELECT * FROM schools ORDER BY county,district_name,division_name,school_name ASC LIMIT 300";
                  if ($_GET["Page"]) {
                    $pageOffset = isset($_GET["Page"]) ? $_GET["Page"] : 1;
                    $offset = ($pageOffset - 1) * 300;
                    $resultSQL.=" OFFSET " . $offset;
                  }
                  $result_set = mysql_query($resultSQL);
                }
?>

                <!--Advanced Search Container-->
                <div id="advanced_search_div" style="display:none;margin:0 auto 20px;opacity:0;margin-left:45%;"> 
                  <p id="advanced_close" class="pull-right btn-small btn-warning"  style="margin:-25px 20px 0 0;cursor:pointer;float:right;">X Close</p>
                  <style type="text/css">
                    .text-wrap {
                      height:50px!important;
                    }
                  </style>
                  <form method="post">

                    <label for="textarea">Enter multiple Division names in the text-area below:</label>
                    <textarea id="textarea" class="example" rows="1" style="width:400px;height:50px;" name="filters"></textarea>
                    <input type="submit" class="btn-filter btn-info" value="Search" name="advanced_search_table"/>
                  </form>

                  <script type="text/javascript" src="js/textext.core.js"></script>
                  <script type="text/javascript" src="js/textext.plugin.autocomplete.js"></script>
                  <script type="text/javascript" src="js/textext.plugin.tags.js"></script>
                  <script type="text/javascript" src="js/textext.plugin.suggestions.js"></script>
                  <script type="text/javascript" src="js/textext.plugin.filter.js"></script>
                  <script type="text/javascript">
            var suggestion = ['<?php echo $suggestions ?>'];
            $('#textarea')
                    .textext({
              plugins: 'autocomplete suggestions tags filter',
              suggestions: suggestion
            });
                  </script>
                </div>
                <form>
                   <input type="submit" class="btn-filter btn-info" value="Advanced Search" name="advanced_search_table"/>
             <label for="textarea">Enter multiple Division names in the text-area below:</label>
                    <textarea id="textarea" class="example" rows="1" style="width:400px;height:50px;" name="filters"></textarea>
                    <input type="submit" class="btn-filter btn-info" value="Search" name="advanced_search_table"/>
                  </form>
                  <script type="text/javascript" src="js/textext.core.js"></script>
                  <script type="text/javascript" src="js/textext.plugin.autocomplete.js"></script>
                  <script type="text/javascript" src="js/textext.plugin.tags.js"></script>
                  <script type="text/javascript" src="js/textext.plugin.suggestions.js"></script>
                  <script type="text/javascript" src="js/textext.plugin.filter.js"></script>
                  <script type="text/javascript">
                    var suggestion = ['<?php echo $suggestions ?>'];
                    $('#textarea').textext({
                      plugins: 'autocomplete suggestions tags filter',
                      suggestions: suggestion
                    });
                  </script>
                   <!--Toggle Advanced Search-->
            <script type="text/javascript">
              var searchHeight = $('#search_div').innerHeight() + $('#advanced_open').outerHeight();
              $("#advanced_open").click(function() {
                $('#search_div').animate({
                  'height': 0, 'opacity': 0
                }, 100, function() {
                  $(this).css('display', 'none');
                  $('#advanced_search_div').css({
                    'display': 'inline-block', 'height': 'auto', }).animate({
                    'opacity': 1
                  }, 200);
                });
              });
              $('#advanced_close').click(function() {
                $('#advanced_search_div').animate({
                  'height': 0, 'opacity': 0
                }, 200, function() {
                  $(this).css('display', 'none');
                  $('#search_div').css({'display': 'block'}).animate({
                    'height': '26px', 'opacity': '1'
                  }, 100);
                });
              });
            </script>
