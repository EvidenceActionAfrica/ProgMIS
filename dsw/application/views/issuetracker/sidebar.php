<div class="col-md-2 sidebar">
    <h4 class="">Issue Tracker</h4>
     <ul>
        <li><a href="<?php echo URL; ?>issuetracker/viewApproved/No/1">Unresolved Issues</a></li>
        <li><a href="<?php echo URL; ?>issuetracker/viewApproved/No/2">Resolved & Unapproved Issues</a></li>
        <li><a href="<?php echo URL; ?>issuetracker/completelyApproved">Completed Issues</a></li>
        <li><a href="<?php echo URL; ?>issuetracker/tracker/">All Issues</a></li>
        <li><span style='font-size:1.2em;font-weight:bold;'><a data-toggle="collapse" data-parent="#accordion" href="#collapseSettings">Settings<span class="caret"></span></a></span></li>
        <ul id="collapseSettings" class="panel-collapse collapse">
          	<li><a href="<?php echo URL; ?>generalclass/general/issues_category">Issue Category & Codes</a></li>
	        <li><a href="<?php echo URL; ?>issuetracker/message_template/issue_message_templates">Message Template</a></li>
        </ul>                  
    </ul>
</div>