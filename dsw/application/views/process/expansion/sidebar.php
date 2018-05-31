<style>
    *{
        padding:0%;
        margin:0%;
    }
</style>

<div class="col-md-2 sidebar">
    <div class="expansion">
       <ul>
        <li><span style='font-size:1em;'><a data-toggle="collapse" data-parent="#accordion" href="#collapseLSM"> LSM<span class="caret"></span></a></span> </li>
        <ul id="collapseLSM" class="panel-collapse collapse">
           <li><a href="<?php echo URL; ?>expansion/viewLsm">Create LSM</a></li>
           <li><a href="<?php echo URL; ?>expansion/viewCompleteLsm">View All Scheduled LSM </a></li>
           <li><a href="<?php echo URL; ?>expansion/lsmtracking/">Tracking</a></li>
        </ul>
       
     <li><span style='font-size:1em;'><a data-toggle="collapse" data-parent="#accordion" href="#collapseSitePlanning"> Waterpoint <br/>Verification<span class="caret"></span></a></span> </li>
        
            <ul id="collapseSitePlanning" class="panel-collapse collapse">
                  <li><a href="<?php echo URL; ?>expansion/siteVerification/">Plan A Verification</a></li>
                  <li><a href="<?php echo URL; ?>expansion/siteVerificationComplete/">View All Planned Verifications</a></li>
                  <li><a href="<?php echo URL; ?>expansion/siteVerificationTrack/">Track Verifications</a></li>
                  <li><a href="<?php echo URL; ?>expansion/sVerificationUpload/">Upload Results</a></li>
                  
                
            </ul>
     
   <li><span style='font-size:1em;'><a data-toggle="collapse" data-parent="#accordion" href="#collapseVCSPlanning">VCS<span class="caret"></span></a></span> </li>
    
            <ul id="collapseVCSPlanning" class="panel-collapse collapse">
                  <li><a href="<?php echo URL; ?>expansion/Transition/site_verification/vcsVerification/Waterpoint_verification">Plan VCS</a></li>
                  <li><a href="<?php echo URL; ?>expansion/vcsVerificationComplete/">View All View Planned VCS</a></li>
                 <li><a href="<?php echo URL; ?>expansion/vcsVerificationTrack/">Track VCS</a></li>
            </ul>
   
  <li><span style='font-size:1em;'><a data-toggle="collapse" data-parent="#accordion" href="#collapseDispenserPlanning">Dispenser<br/> Installation &CEM<span class="caret"></span></a></span> </li>
      
            <ul id="collapseDispenserPlanning" class="panel-collapse collapse">
                  <li><a href="<?php echo URL; ?>expansion/Transition/vcs_schedule/dispenserInstall/vcs">Plan An Installation/CEM</a></li>
                  <li><a href="<?php echo URL; ?>expansion/dispenserInstallComplete/">View All Planned Installations/Cems</a></li>
                  <li><a href="<?php echo URL; ?>expansion/dispenserInstallTrack/">Installation-Cem Tracker</a></li>
         
            </ul>
     
      
   <li><span style='font-size:1em;'><a data-toggle="collapse" data-parent="#accordion" href="#collapseSettings">Settings<span class="caret"></span></a></span> </li>
        <ul id="collapseSettings" class="panel-collapse collapse">
            
            <li><a href="<?php echo URL; ?>expansion/programSet/message_templates/">Message Template </a></li> 
            <li><a href="<?php echo URL; ?>expansion/displaySet/expansion_display_manager/">Display Manager </a></li> 
            <li><a href="<?php echo URL; ?>expansion/displaySet/field_officer_assignment/">Field Officer Assignment</a></li> 
            <li><a href="<?php echo URL; ?>expansion/displaySet/lsm_default_check/">Lsm Cau Default</a></li> 
            <li><a href="<?php echo URL; ?>expansion/testOdkCalls/">Test ODK </a></li> 
             
        </ul>
     
      



</ul>



</div>
 </div>