<?php





unset($selectFields);
unset($whereFields);
unset($whereVals);

$strSql="";
$strSql="Select * from "._HOMEPAGE_MASTER_TABLE_." where elementId in("._HOMEPAGE_RIGHT_TOP_PIC_ID_.","._HOMEPAGE_VIDEO_ID_.")";

$res=getRecords(_HOMEPAGE_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$strSql);

if($res)
{
	while($row=mysql_fetch_array($res))
	{
		$elementId=$row["elementId"];
		
		switch($elementId)
		{
			case _HOMEPAGE_RIGHT_TOP_PIC_ID_ :
				$rightImageLinkTarget=$row["elementLinkTarget"];
				$rightImageLinkUrl=$row["elementLinkUrl"];
				$rightImage=$row["elementImage"];
				$rightImageTitle=$row["elementTitle"];
			break;
		
			default :
			break;
			
			
		}
	}
}


?>
<div id="bodyright">
  <div class="contentbox">
  
  <div class="grayshadebox2">
  <form name="frmSearchRight" id="frmSearchRight" action="search.php" method="post">
  <h5>Search</h5>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:10px;">
  <tr>
    <td align="left"><input name="txtKeywords" id="txtKeywords" type="text" class="graytextf" style="width:250px;" value="<?php echo $_REQUEST['txtKeywords']; ?>" /></td>
    <td width="13%" align="right"><input type="image" src="images/searchicon.GIF" width="32" border="0" /></td>
  </tr>
</table>


  <table width="275" border="0" cellpadding="2" cellspacing="0">
    <tr>
      <td width="20"><input name="txtSearchType" id="txtSearchType" type="radio" value="1" <?php if($_REQUEST['txtSearchType']==1 || $_REQUEST['txtSearchType']=='') echo 'checked="checked"'; ?> /></td>
      <td width="103">All</td>
      <td width="20"><input name="txtSearchType" id="txtSearchType" type="radio" value="5"  <?php if($_REQUEST['txtSearchType']==5) echo 'checked="checked"'; ?>/></td>
      <td width="116">General</td>
    </tr>
    <tr>
      <td><input name="txtSearchType" id="txtSearchType" type="radio" value="3"  <?php if($_REQUEST['txtSearchType']==3) echo 'checked="checked"'; ?>/></td>
      <td>Projects</td>
      <td><input name="txtSearchType" id="txtSearchType" type="radio" value="4"  <?php if($_REQUEST['txtSearchType']==4) echo 'checked="checked"'; ?>/></td>
      <td>Announcements</td>
    </tr>
  </table>
  </form>
  </div>
  
  
  </div>
  
  <?php
  unset($selectFields);
  unset($whereFields);
  unset($whereVals);
  
  $selectFields[0]="count(*)";
  
  $whereFields[0]="memberStatus";
  $whereFields[1]="memberType";
  
  $whereVals[0]=1;
  $whereVals[1]=2;
  
  $resMemberCount=getRecords(_MEMBER_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_N_,'');
  
  if($resMemberCount)
  {
	  while($rowMemberCount=mysql_fetch_array($resMemberCount))
	  {
		 $totalMembers=$rowMemberCount[0]; 
	  }
  }


  unset($selectFields);
  unset($whereFields);
  unset($whereVals);
  
  $selectFields[0]="*";
  
  $whereFields[0]="memberStatus";
  $whereFields[1]="memberType";
  
  $whereVals[0]=1;
  $whereVals[1]=2;
  
  $resMemberLatest=getRecords(_MEMBER_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_N_,'','memberId','DESC',1,0);
  
  if($resMemberLatest)
  {
	  while($rowMemberLatest=mysql_fetch_array($resMemberLatest))
	  {
		 $latestMemberFirstName=$rowMemberLatest["memberFirstName"]; 
		 $latestMemberLastName=$rowMemberLatest["memberLastName"]; 
	  }
  }


  unset($selectFields);
  unset($whereFields);
  unset($whereVals);
  
  $selectFields[0]="count(*)";
  
  $whereFields[0]="threadStatus";
  
  $whereVals[0]=1;
  
  $resThreadCount=getRecords(_THREADS_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_N_,'');
  
  if($resThreadCount)
  {
	  while($rowThreadCount=mysql_fetch_array($resThreadCount))
	  {
		 $totalThreads=$rowThreadCount[0]; 
	  }
  }



  unset($selectFields);
  unset($whereFields);
  unset($whereVals);
  
  $selectFields[0]="count(*)";
  
  $whereFields[0]="threadStatus";
  
  $whereVals[0]=1;
  
  $resThreadCount=getRecords(_THREADS_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_N_,'');
  
  if($resThreadCount)
  {
	  while($rowThreadCount=mysql_fetch_array($resThreadCount))
	  {
		 $totalThreads=$rowThreadCount[0]; 
	  }
  }


  unset($selectFields);
  unset($whereFields);
  unset($whereVals);
  
  $selectFields[0]="count(*)";
  
  $whereFields[0]="postStatus";
  
  $whereVals[0]=1;
  
  $resPostCount=getRecords(_POSTS_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_N_,'');
  
  if($resPostCount)
  {
	  while($rowPostCount=mysql_fetch_array($resPostCount))
	  {
		 $totalPost=$rowPostCount[0]; 
	  }
  }
  ?>
  
  <div class="contentbox">
    <div class="grayshadebox2">
      <h4>Search</h4>
      <div style="padding-top:5px; font-size:14px;">Total Members: <?php echo $totalMembers; ?><br />
        Threads: <?php echo $totalThreads; ?><br />
        Total Posts: <?php echo $totalPost; ?><br />
        Newest Member: <?php echo $latestMemberFirstName; ?> <?php echo $latestMemberLastName; ?></div>
      </div>
  </div>
  <div class="contentbox">
    <div class="grayshadebox2">
      <h4>Latest Threads</h4>
      <div style="padding-top:5px; font-size:14px;">
      <?php

		  unset($selectFields);
		  unset($whereFields);
		  unset($whereVals);
		  
		  $strSqlLatest="";
		  $strSqlLatest="Select a.*,b.memberFirstName,b.memberLastName,b.memberCompany,b.memberPhoto from "._THREADS_MASTER_TABLE_." a left outer join "._MEMBER_MASTER_TABLE_." b on a.addedBy=b.memberId  where  a.threadStatus=1 order by a.threadId DESC LIMIT 0,3";
		  
		  $resThreadsLatest=getRecords(_THREADS_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$strSqlLatest);
		  
		  if($resThreadsLatest)
		  {
			  while($rowThreadsLatest=mysql_fetch_array($resThreadsLatest))
			  {
	  ?>
                  <div class="latestpost"><table width="100%" border="0" cellpadding="3" cellspacing="0">
                      <tr>
                        <td width="20%" rowspan="4" align="left" valign="top" style="padding-right:5px;"><img src="memberPhotos/<?php echo $rowThreadsLatest['memberPhoto']; ?>" onerror="this.src='images/buddy.GIF';" width="50" /></td>
                        <td width="80%" align="left" valign="top"><a href="thread-details.php?tid=<?php echo $rowThreadsLatest["topicId"]; ?>&thread=<?php echo $rowThreadsLatest["threadId"]; ?>"><strong><?php echo $rowThreadsLatest["threadTitle"]; ?></strong></a></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" style="font-size:11px;"><?php echo $rowThreadsLatest["memberFirstName"]; ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" style="font-size:11px;"><strong><?php echo substr(strip_tags($rowThreadsLatest["threadDescription"]),0,20); ?>...</strong></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" style="font-size:11px; text-align:right;"><?php echo date("d-m-Y",strtotime($rowThreadsLatest["dateAdded"])); ?> </td>
                      </tr>
                    </table>
                  </div>
      <?php
			  }
		  }
	  
	  ?>
      
      </div>
    </div>
  </div>
  <?php include_once('codelibrary/inc/right-steering-member.inc.php'); ?>
  
  
  <div class="contentbox">
  <a href="<?php echo $rightImageLinkUrl; ?>" target="<?php if($rightImageLinkTarget==0) { ?> _self <?php }elseif($rightImageLinkTarget==1){ ?>_blank <?php } ?>"><img src="userUploads/<?php echo $rightImage; ?>" style="margin-bottom:5px;" /></a>
  <strong><?php echo $rightImageTitle; ?>  </strong></div>
  </div>