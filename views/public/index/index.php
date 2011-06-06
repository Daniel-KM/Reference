<?php head(array('title'=>'Browse Items by Subject','bodyid'=>'subject-browse','bodyclass' => 'subject-browse')); ?>
<script type="text/javascript">
    jQuery.noConflict();
    jQuery(document).ready(function(){
        var path = location.pathname;
        var search = location.search;
        var hash = location.hash;
        var pat = path + search + hash;

                jQuery(".navigation a").parent().removeClass("current");
                jQuery(".navigation a[href=" + pat  + "]").parent().addClass("current");
        });
</script>
<?php
  $db = get_db();
             $select = "SELECT DISTINCT text
                        FROM " . $db->ElementTexts . "
                        WHERE element_id='" . get_option('subject_browse_DC_Subject_id') . "'
                        ORDER BY text;";
             $result = $db->fetchAll($select);
?>
	<div id="primary" class="subject-browse">
	
      <h1>Browse By Subject (<?php echo count($result); ?> Headings)</h1>
  		<ul class="items-nav navigation" id="secondary-nav">
			<?php echo public_nav_items(array('Browse All' => uri('items'), 'Browse by Tag' => uri('items/tags'), 'Browse by Collection' => uri('collections'))); ?>
		</ul>
                <div class="pagination sb-pagination" id="pagination-top"><ul class="pagination_list">
                      <!-- Alphabetical Helpers -->
                      <?php echo '<li class="pagination_range"><a href="#number">#0-9</a></li>';
                            foreach(range('A','Z') as $i) {echo "<li class='pagination_range'><a href='#$i'>$i</a></li>";}?>                      
                                              </ul>
                                              </div>
                      <div id="sb-subject-headings">
                        <?php
                        $current_header = '';
                        foreach ($result as $row) {
                          $first_char = substr($row['text'],0,1);
                          if (preg_match('/\W|\d/',$first_char )){
                            $first_char = '#0-9';
                          }
                          if ($current_header !== strtoupper($first_char)){
                            $current_header = strtoupper($first_char);
                            if ($current_header === '#0-9'){
                              echo "<h3 class='sb-subject-heading' id='number'>$current_header</h3>";
                            }
                            else {
                              echo "<h3 class='sb-subject-heading' id='$current_header'>$current_header</h3>";
                            }
                          }
                          
                          echo '<p class="sb-subject"><a href="' . uri('items/browse?search=&advanced[0][element_id]=' . get_option('subject_browse_DC_Subject_id' . '&advanced[0][type]=contains&advanced[0][terms]='. urlencode($row['text']) .'&submit_search=Search') . '">' . $row['text'] . '</a></p>';
                        }
                        ?>
                        
                        </div>
                        
                      <div class="pagination sb-pagination" id="pagination-bottom"><ul class="pagination_list">
                      <!-- Alphabetical Helpers -->
                      <?php echo '<li class="pagination_range"><a href="#number">#0-9</a></li>';
                            foreach(range('A','Z') as $i) {echo "<li class='pagination_range' style='float:none;'><a href='#$i'>$i</a></li>";}?>
                      
                      
                                              </ul>
                                              </div>
		
			
	</div><!-- end primary -->
	
<?php foot(); ?>