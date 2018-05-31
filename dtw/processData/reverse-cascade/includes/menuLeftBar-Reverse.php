 <?php  $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";  ?>
<h3>Financial Returns</h3>
<ul>
 <a href="return-county.php"><li <?php if (strpos($url,'return-county.php') !== false) { echo 'class="linkActive"';} ?>  >County Returns</li></a>
 <a href="return-status.php"><li <?php if (strpos($url,'return-status.php') !== false) { echo 'class="linkActive"';} ?> >Sub-County Returns</li></a>
</ul>
<br/>
<h3>Forms</h3>
<ul>
  <div class="panel-group" id="accordion">
  <div class="panel panel-default no-background">
    <div >
      <li class="panel-title">
         <a href="log-export-planning.php"><li <?php if (strpos($url,'log-export-planning.php') !== false) { echo 'class="linkActive"';} ?> >Planning</li></a>
         <a href="log-export-treatment.php"><li <?php if (strpos($url,'log-export-training.php') !== false) { echo 'class="linkActive"';} ?> >Treatment</li></a>

      </li>
    </div>
    <!-- <div id="collapseTwo" class="panel-collapse collapse">
      <div class="panel-body">
      <a href="log-export.php?log=P"><li  style="list-style:none;" <?php if (strpos($url,'log-export.php?log=P') !== false) { echo 'class="linkActive"';} ?> > Log P</li></a>
      <a href="log-export.php?log=MT"><li style="list-style:none;" <?php if (strpos($url,'log-export.php?log=MT') !== false) { echo 'class="linkActive"';} ?> > Log MT</li></a>
      <a href="log-export.php?log=ATTNSC"><li <?php if (strpos($url,'log-export.php?log=ATTNSC') !== false) { echo 'class="linkActive"';} ?> >Log ATTNSC</li></a>
      </div>
    </div>
  </div> -->
  <div class="panel panel-default no-background">
     <div >
       <li class="panel-title">
         <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
          <a href="log-export-training.php"><li <?php if (strpos($url,'log-export-training.php') !== false) { echo 'class="linkActive"';} ?> >Training</li></a>

         </a>
       </li>
     </div>
     <div id="collapseOne" class="panel-collapse collapse">
       <div class="panel-body">
        


       </div>
     </div>
   </div>

  <div class="panel panel-default no-background">
    <div >
      
    </div>
    <div id="collapseThree" class="panel-collapse collapse">
      <div class="panel-body">
   


 </div>
    </div>
  </div>
</div>

</ul>
<br/>

<h3>Batch Forms</h3>
<ul>
 <div class="panel-group" id="accordion">

  <div class="panel panel-default no-background">
    <div >
      <li class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
          &bull; Planning
        </a>
      </li>
    </div>
    <div id="collapseFive" class="panel-collapse collapse">
      <div class="panel-body">
      <a href="batch-export.php?batch=P"><li <?php if (strpos($url,'batch-export.php?batch=P') !== false) { echo 'class="linkActive"';} ?> > Log P</li></a>
      <a href="batch-export.php?batch=MT"><li <?php if (strpos($url,'batch-export.php?batch=MT') !== false) { echo 'class="linkActive"';} ?> > Log MT</li></a>
      <a href="batch-export.php?batch=ATTNR"><li <?php if (strpos($url,'batch-export.php?ATTNR') !== false) { echo 'class="linkActive"';} ?> > ATTNSC</li></a>
      </div>
    </div>
  </div>
  <div class="panel panel-default no-background">
    <div >
      <li class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
          <li>&bull; Training</li>
        </a>
      </li>
    </div>
    <div id="collapseFour" class="panel-collapse collapse">
      <div class="panel-body">
        <a href="batch-export.php?batch=ATTNT"><li <?php if (strpos($url,'batch-export.php?ATTNT') !== false) { echo 'class="linkActive"';} ?> > ATTNT</li></a>
        <a href="batch-export.php?batch=ATTNC"><li <?php if (strpos($url,'batch-export.php?ATTNC') !== false) { echo 'class="linkActive"';} ?> > ATTNC</li></a>
      </div>
    </div>
  </div>

  <div class="panel panel-default no-background">
    <div >
      <li class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
          &bull; Treatment
        </a>
      </li>
    </div>
    <div id="collapseSix" class="panel-collapse collapse">
      <div class="panel-body">
        <a href="batch-export.php?batch=S"><li <?php if (strpos($url,'batch-export.php?S') !== false) { echo 'class="linkActive"';} ?> > Log S</li></a>
        <a href="batch-export.php?batch=A"><li <?php if (strpos($url,'batch-export.php?A') !== false) { echo 'class="linkActive"';} ?> > Log A</li></a>
        <a href="batch-export.php?batch=D"><li <?php if (strpos($url,'batch-export.php?D') !== false) { echo 'class="linkActive"';} ?> > Log D</li></a>
      </div>
    </div>
  </div>
</div>

</ul>
<br/>



<h3>Upload Forms</h3>
<ul>
 <a href="form_mtUpload.php"><li <?php if (strpos($url,'form_mtUpload') !== false) { echo 'class="linkActive"';} ?> >Form MT</li></a>
 <a href="form_sUpload.php"><li <?php if (strpos($url,'form_s_Upload') !== false) { echo 'class="linkActive"';} ?> >Form S</li></a>
 <a href="form_aUpload.php"><li <?php if (strpos($url,'form_aUpload') !== false) { echo 'class="linkActive"';} ?> >Form A</li></a>
<a href="form_atttntUpload.php"><li <?php if (strpos($url,'form_atttntUpload') !== false) { echo 'class="linkActive"';} ?> >Form ATTNT</li></a>
<a href="form_dUpload.php"><li <?php if (strpos($url,'form_dUpload') !== false) { echo 'class="linkActive"';} ?> >Form D</li></a>
<a href="import-p.php"><li <?php if (strpos($url,'import-p') !== false) { echo 'class="linkActive"';} ?> >Form P</li></a>

</ul>
<br/>

<h3>Input Forms</h3>
<ul>
 <a href="form_d.php#selectDistrictFormD"><li <?php if (strpos($url,'form_d') !== false) { echo 'class="linkActive"';} ?> >Form D</li></a>
 <a href="form_d_view.php"><li <?php if (strpos($url,'form_d_view') !== false) { echo 'class="linkActive"';} ?> >Form D view</li></a>
 <a href="form_a.php"><li <?php if (strpos($url,'form_a') !== false) { echo 'class="linkActive"';} ?> >Form A</li></a>
 <!-- <a href="form_p.php#selectDivisionFormP"><li <?php if (strpos($url,'form_p') !== false) { echo 'class="linkActive"';} ?> >Form P Print</li></a> -->
</ul>


  