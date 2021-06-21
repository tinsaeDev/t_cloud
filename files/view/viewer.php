
<?php
	
	include (" ../../sec.php");

	if (!isset($user)) {
		header("location:../../login/home.php");
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>File Explorer</title>

<link rel="stylesheet" type="text/css" href="view.css">

<script type="text/javascript" src="viewer.js"></script>
<script type="text/javascript" src="share.js"></script>

<script type="text/javascript">
	window.onload = function(){
		initViewer();
		initShare();
	}
</script>
</head>
<body>
	

		<div class="fileexplorer"  id="fileexplorer">
			 
			<div class="fileexplorer-omnibar"  id="fileexplorer-omnibar"> 

				<div class="fileexplorer-omnibar-home-back">
					<button class="fileexplorer-omnibar-home" onclick="loadUploadedFiles('')"> <img class="fileexplorer-omnibar-home-image" src="home.png"> </button>
					<button class="fileexplorer-omnibar-back" onclick="backLoad()"> <img class="fileexplorer-omnibar-back-image" src="back.png" "> </button>
				</div>

					<div  class="fileexplorer-path">
						<label id="fileexplorer-path"  class="fileexplorer-path-address">Path</label>
						<input id="fileexplorer-seach-input" class="fileexplorer-search-input">
					</div>

					<button class="fileexplorer-search" onclick="searchFiles()"> Search </button>

				<div class="account-div">
						<button class="account-div-logout"  onclick="javascript:void( window.location='../../login/accountsetting.php' )" >Account Setting </button>
						<button class="account-div-logout"  onclick="javascript:void( window.location='../../login/logout.php' )" >Logout( <?php echo $user ?>) </button>
				</div>

			</div>
				
			<div>
				<button class="fileexplorer-new-file" onclick="uploadFile()" > <img src="upload.png" height="16px" width="16px"> Upload</button>
				<button class="fileexplorer-new-folder " onclick="createFolder()" > <img src="newfolder.png" height="16px" width="16px"> New Folder</button>
				<label id="storage-usage" class="storage-usage"></label>
			</div>

				
			<div class="fileexplorer-explorer"  id="fileexplorer-explorer">
				<div class="fileexplorer-explorer-navigator"  id="fileexplorer-explorer-navigator">

						<button  class="fileexplorer-explorer-navigator-button" onclick="loadUploadedFile('')"> <img src="uploaded.png" width="32px" height="32px"> Uploaded Files</button>
						<button  class="fileexplorer-explorer-navigator-button" onclick="loadTheySharedFile()"> <img src="share.png" width="32px" height="32px"> Shared With Me</button>
						<button  class="fileexplorer-explorer-navigator-button" onclick="loadSharedFile()"> <img src="share.png" width="32px" height="32px"> I Shared</button>
						<button  class="fileexplorer-explorer-navigator-button" onclick="loadTrashedFiles()"> <img src="trash.png" width="32px" height="32px"> Trash</button>

				</div>
				
				<div class="fileexplorer-explorer-browser-outer">
						
						<div class="fileexplorer-explorer-browser"  id="fileexplorer-explorer-browser" onclick="clickExplorer()" ondblclick="dblclickExplorer(event)" oncontextmenu="contextmenuExplorer(event)">
					
						</div>

					<div class="fileexplorer-explorer-browser-info" id="fileexplorer-explorer-browser-info">

					
						<info class="fileexplorer-explorer-browser-info-info">
							<attribute class="fileexplorer-explorer-browser-info-info-attribute">Size</attribute>
							<value class="fileexplorer-explorer-browser-info-info-value" id="fileexplorer-explorer-browser-info-info-value-size" ></value>
						</info>



					
						<info class="fileexplorer-explorer-browser-info-info">
							<attribute class="fileexplorer-explorer-browser-info-info-attribute">Type</attribute>
							<value class="fileexplorer-explorer-browser-info-info-value" id="fileexplorer-explorer-browser-info-info-value-type" ></value>
						</info>



					
						<info class="fileexplorer-explorer-browser-info-info">
							<attribute class="fileexplorer-explorer-browser-info-info-attribute">Shared</attribute>
							<value class="fileexplorer-explorer-browser-info-info-value" id="fileexplorer-explorer-browser-info-info-value-shared" ></value>
						</info>

					

					</div>

				</div>
			</div>
		</div>

		<!-- Popup menus on file -->
		<div class="popup-menu-file" id="popup-menu-file">
			<button class="popup-menu-file-menu" onclick="clickListenerDownload()">Download</button>
			<button class="popup-menu-file-menu" onclick="clickListenerShare()">Share</button>
			<button class="popup-menu-file-menu" onclick="clickListenerRename()">Rename</button>
			<button class="popup-menu-file-menu" onclick="clickListenerCopy()">Copy</button>
			<button class="popup-menu-file-menu" onclick="clickListenerCut()">Cut</button>
			<button class="popup-menu-file-menu" onclick="clickListenerTrash()">Move To Trash</button>
		</div>
		


		<!-- Popup menus on  trashed file -->
		<div class="popup-menu-trashed-file" id="popup-menu-trashed-file">
			<button class="popup-menu-trashed-file-menu" onclick=" clickListenerRestore() ">Restore</button>
			<button class="popup-menu-trashed-file-menu" onclick="clickListenerDeleteForever('t')">Delete Forever</button>
		</div>
		



		<!-- Popup menus on  i shared file -->
		<div class="popup-menu-ishared-file" id="popup-menu-ishared-file">
			<button class="popup-menu-ishared-file-menu" onclick=" clickListenerShare() ">Share / Unshare</button>
		</div>
		



		<!-- Popup menus on  i shared file -->
		<div class="popup-menu-theyShared-file" id="popup-menu-theyShared-file">
			<button class="popup-menu-theyShared-file-menu" onclick=" clickListenerDownload() ">Download</button>
		</div>
		


		<div class="popup-menu-folder" id="popup-menu-folder">

			<button class="popup-menu-folder-menu" onclick="clickListenerOpen()">Open</button>
			<button class="popup-menu-folder-menu" onclick="clickListenerTrash('u')">Move to Trash</button>
		</div>


		<div class="popup-menu-explorer" id="popup-menu-explorer">
			<button class="popup-menu-explorer-menu" onclick="clickListenerPaste()">paste</button>
			<button class="popup-menu-explorer-menu" onclick="clickListenerRefresh()">Refresh</button>
		</div>



		<div class="popup-menu-explorer" id="popup-trash-menu-explorer">
			<button class="popup-menu-explorer-menu" onclick="emptyTrashBin()">Empty Trash Bin</button>
			<button class="popup-menu-explorer-menu" onclick="clickListenerRefreshTrash()">Refresh</button>
		</div>






		<!--A popup menu that openess when user dbouldclicks a file.-->
		<div class="file-download-popup-overlay" id="file-download-popup-overlay"></div>
		<div class="file-download-popup" id="file-download-popup">
			<img class="file-download-popup-image" src="file.png">
			<div class="file-download-popup-detail">
				<label class="file-download-popup-detail-attribute" id="file-download-popup-detail-attribute-name" ></label>
				<label class="file-download-popup-detail-attribute" id="file-download-popup-detail-attribute-type" ></label>
				<label class="file-download-popup-detail-attribute" id="file-download-popup-detail-attribute-size" ></label>
			</div>
			<button class="file-download-popup-download" onclick="downloadFileFinal()" >Download</button>
			<button class="file-download-popup-cancel" onclick="cancelFileDownload()" >Cancel</button>
 		</div>






 		<!-- A popup menu that openes when user tries to rename a file. -->
 		<div class="rename-file-popup-overlay" id="rename-file-popup-overlay"></div>
 		<div class="rename-file-popup" id="rename-file-popup">
 			<div class="rename-file-popup-header">
 				<label class="rename-file-popup-header-title">Rename</label>
 			</div>
 			<div class="rename-file-popup-content">
 				<input class="rename-file-popup-content-input" type="text" id="rename-file-popup-content-input">
 				<div class="rename-file-popup-content-buttons">
 					<button class="rename-file-popup-content-buttons-raname" onclick=" renameFileFinal() " >Rename</button>
 					<button class="rename-file-popup-content-buttons-cancel" onclick=" calcelFileRename() " >Cancell</button>
 				</div>
 			</div>
 		</div>



 		<!-- A popup menu that openes when user tries to creare a folder. -->
 		<div class="create-folder-popup-overlay" id="create-folder-popup-overlay"></div>
 		<div class="create-folder-popup" id="create-folder-popup">
 			<div class="create-folder-popup-header">
 				<label class="create-folder-popup-header-title">New Folder</label>
 			</div>
 			<div class="create-folder-popup-content">
 				<input class="create-folder-popup-content-input" type="text" id="create-folder-popup-content-input">
 				<div class="create-folder-popup-content-buttons">
 					<button class="create-folder-popup-content-buttons-create" onclick="createFolderFinal()" >Create</button>
 					<button class="create-folder-popup-content-buttons-cancel" onclick="cancelCreateFolder()">Cancel</button>
 				</div>
 			</div>
 		</div>




 		

 		<!-- A popup menu that opened when user tries to delete file. -->
 		<div class="delete-file-popup-overlay" id="delete-file-popup-overlay"></div>
 		<div class="delete-file-popup" id="delete-file-popup">
 			<div class="delete-file-popup-header">
 				<label class="delete-file-popup-header-title">Delete</label>
 			</div>
 			<div class="delete-file-popup-content">
 				<label class="delete-file-popup-content-question" type="text" name="">Are you sure? to permanently delete file?</label>
 				<div class="delete-file-popup-content-buttons">
 					<button class="delete-file-popup-content-buttons-delete" onclick="deleteFileForeverFinal()">Delete</button>
 					<button class="delete-file-popup-content-buttons-cancel" onclick="cancelDeleteFileForever()">Cancell</button>
 				</div>
 			</div>
 		</div>





 		<!-- A popup menu that opened when user tries to delete file. -->
 		<div class="trash-file-popup-overlay" id="trash-file-popup-overlay"></div>
 		<div class="trash-file-popup" id="trash-file-popup">
 			<div class="trash-file-popup-header">
 				<label class="trash-file-popup-header-title">Send to Trash</label>
 			</div>
 			<div class="trash-file-popup-content">
 				<label class="trash-file-popup-content-question" type="text" name="">Are you sure?, to send file to trash.</label>
 				<div class="trash-file-popup-content-buttons">
 					<button class="trash-file-popup-content-buttons-delete" onclick="trashFileFinal()">Trash</button>
 					<button class="trash-file-popup-content-buttons-cancel" onclick="calcelTrashingFile()">Cancell</button>
 				</div>
 			</div>
 		</div>





 		<!-- A popup that opens during file upload. --->
 		<div class="upload-file-popup-overlay" id="upload-file-popup-overlay"></div>
 		<div class="upload-file-popup" id="upload-file-popup">
 		
 			<input type="file" id="upload-file-popup-input" hidden onchange="selectedFileChange()">

			<div class="upload-file-popup-header">
 				<label class="upload-file-popup-header-title">Upload File</label>
 			</div>

 			<div class="upload-file-popup-content">
		 			<div class="upload-file-popup-select">
		 				<button  class="upload-file-popup-selectfile" id="upload-file-popup-selectfile"  onclick=" document.getElementById('upload-file-popup-input').click(); ">Select File</button>
						<label class="upload-file-popup-label" id="uploading-label"> Uploading </label> 
							<div class="upload-file-popup-progress-container" >
								<div class="upload-file-popup-progress" id="upload-progress"></div>
							</div>
		 			</div>
		 			
		 			<div  class="upload-file-popup-buttons">
		 					<button  class="upload-file-popup-buttons-upload" id="upload-file-popup-buttons-upload" onclick="uploadFileFinal()" disabled>Upload</button>
		 					<button  class="upload-file-popup-buttons-cancel" onclick="cancelFileUpload()">Cancel</button>
		 			</div>
 			</div>
 		</div>





 		<!-- A popup that is shown when user is about to share/unshare file   -->

 		<div class="share-file-popup-overlay" id="share-file-popup-overlay"></div>
 		<div class="share-file-popup" id="share-file-popup">
 			<div class="share-file-popup-header">	
 				<label class="share-file-popup-header-titile">Share</label>
 				<input class="share-file-popup-header-sharestatus" type="checkbox" checked id="share-file-popup-header-sharestatus" onchange="shareFileHeaderStatusChanged()">
 			</div>



 			<div class="share-file-popup-userslist" id="share-file-popup-userslist">	
 			</div>


 			<div class="share-file-popup-adduser">
 				<input type="text" class="share-file-popup-adduser-input" id="share-file-popup-adduser-input">
 				<button onclick="addSharedWithUser()" class="share-file-popup-adduser-addbutton">Add</button>
 			</div>


 			<div class="share-file-popup-save">
 				<button onclick="saveSharedWithUsers()" class="share-file-popup-save-savebutton" >Save</button>
 				<button onclick="cancelSharedWithUsers()" class="share-file-popup-save-cancelbutton">Cancel</button>
 			</div>

 		</div>

</body>
</html>