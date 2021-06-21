// *****************************************************************************************************************************************************************************************
// *****************************************************************************************************************************************************************************************
// Function that work with trashed file.

function loadTrashedFiles(arg){


	fileExplorerInfo.style.display = "none";
	hiddeAllPopups();

	if (arg==undefined) {
		arg="";
	}

	loadTrashAjax.open("GET","viewDeleted.php",true);
	loadTrashAjax.send();

}


function showTrashedFiles(responseText) {

				console.log("Loading trashed files.....");
				
				var obj = JSON.parse(responseText);

				

					if ( obj.file.length<1 ) {
						console.debug("empty folder");
						
					}
				var files = obj.file;
				previousDir = obj.parentDir;
				currentDir = obj.currentDir;
				console.log( currentDir ) ;


					fileexplorerbrowser.setAttribute("oncontextmenu","contextmenuTrashExplorer(event)");
					while( fileexplorerbrowser.lastChild ){
						fileexplorerbrowser.removeChild( fileexplorerbrowser.lastChild );
					}


					for( var i = 0; i < files.length; i++  ){
				
						var file = document.createElement("div");
							file.setAttribute("id", files[i].id );
							file.setAttribute("class","fileexplorer-explorer-browser-file");
							file.setAttribute("oncontextmenu","contextmenuTrashedFile(event)");
							

							file.setAttribute("onclick","clickFile(event)");
														

						var fileIcon = document.createElement("img");

							fileIcon.setAttribute("id",files[i].id);
							
							fileIcon.setAttribute("class","fileexplorer-explorer-browser-file-image");
								
										if ( files[i].isDir==1 ) {
											fileIcon.setAttribute("src","folder.png");
										}else{
											fileIcon.setAttribute("src","file.png");	
										}
													

							fileIcon.setAttribute("fid",files[i].id);

						var fileName = document.createElement("label");
							fileName.setAttribute("class","fileexplorer-explorer-browser-file-name");
							fileName.innerHTML = files[i].name;

							file.appendChild(fileIcon);
							file.appendChild(fileName);
							fileexplorerbrowser.appendChild(file);

					}



			}

// *****************************************************************************************************************************************************************************************
// *****************************************************************************************************************************************************************************************

// for events on file.

var filePopupMenu;
var trashedFilePopupMenu;
var isharedFilePopupMenu;
var theySharedFilePopupMenu


var folderPopupMenu;
var explorerPopupMenu;
var explorerTrashPopupMenu
 

var fileDowloadPopupOverlay;
var fileDowloadPopup;

var fileDownloadAttributeName;
var fileDownloadAttributeType;
var fileDownloadAttributeSize;



var  fileExplorerName;
var  fileExplorerType;
var  fileExplorerSize;
var  fileExplorerShared;
var  fileExplorerInfo;


var fileexplorer;
var omnibarAddress;

var preCliked;

var loadUploadedAjax = new XMLHttpRequest();
			loadUploadedAjax.onreadystatechange = function(){
						if( loadUploadedAjax.status == 200 && loadUploadedAjax.readyState==4 ){
							showUploadedFiles( loadUploadedAjax.responseText  );
						}
			}


var loadTrashAjax = new XMLHttpRequest();
			loadTrashAjax.onreadystatechange = function(){
						if( loadTrashAjax.status == 200 && loadTrashAjax.readyState==4 ){
							showTrashedFiles( loadTrashAjax.responseText  );

						}
			}

var currentDir;
var previousDir;


function initViewer(){
		filePopupMenu = document.getElementById('popup-menu-file');
		trashedFilePopupMenu = document.getElementById('popup-menu-trashed-file');
		isharedFilePopupMenu = document.getElementById('popup-menu-ishared-file');
		theySharedFilePopupMenu = document.getElementById('popup-menu-theyShared-file');

		fileDowloadPopupOverlay = document.getElementById('file-download-popup-overlay');
		fileDowloadPopup = document.getElementById('file-download-popup');

		fileDownloadAttributeName = document.getElementById('file-download-popup-detail-attribute-name');
		fileDownloadAttributeType = document.getElementById('file-download-popup-detail-attribute-type');
		fileDownloadAttributeSize = document.getElementById('file-download-popup-detail-attribute-size');


		folderPopupMenu = document.getElementById('popup-menu-folder');
		explorerPopupMenu = document.getElementById('popup-menu-explorer');
		explorerTrashPopupMenu = document.getElementById('popup-trash-menu-explorer');

		fileexplorerbrowser = document.getElementById("fileexplorer-explorer-browser");
		omnibarAddress = document.getElementById("fileexplorer-omnibar-address");



		fileExplorerName = document.getElementById("fileexplorer-explorer-browser-info-info-value-name"); 
		fileExplorerType = document.getElementById("fileexplorer-explorer-browser-info-info-value-type"); 
		fileExplorerSize = document.getElementById("fileexplorer-explorer-browser-info-info-value-size"); 
		fileExplorerShared = document.getElementById("fileexplorer-explorer-browser-info-info-value-shared"); 

		fileExplorerInfo = document.getElementById("fileexplorer-explorer-browser-info");

		loadUploadedFile("");

}
// **********************************************************************************************************************************
// functions used to fetch file listing
			function loadUploadedFile(arg){


					shareCaller = "uploaded";
					fileExplorerInfo.style.display = "flex";
					hiddeAllPopups();
					unmarkSelectedFile(preCliked);

					loadUploadedAjax.open("GET","viewUpload.php?parent="+arg,true);
					loadUploadedAjax.send();
			}

			function showUploadedFiles(responseText) {
				var obj = JSON.parse(responseText);
				// show the current directory
				pathDOM = document.getElementById("fileexplorer-path");
				path = obj.folderPath.split("/home/tcloud/uploaded_files/")[1];
				path = path.split(obj.user)[1];
				pathDOM.innerText = path;
				document.title = "tcloud inside "+ path;
			
								// storage usage
								totalSize = obj.totalSpace;
								totalSize = totalSize / 1000000000;
								usedSpace = obj.usedSpace;
								var sizeMeasure = "";
								if (usedSpace > 1000000000) {
									usedSpace = usedSpace / 1000000000;
									sizeMeasure = "GB";
								}
								else if (usedSpace > 1000000) {
									usedSpace = usedSpace / 1000000;
									sizeMeasure = "MB";
								}
								else if (usedSpace > 1000) {
									usedSpace = usedSpace / 1000;
									sizeMeasure = "KB";
								}
								else {
									usedSpace = usedSpace;
									sizeMeasure = "Byte";
								}
								var storageUsageDOM = document.getElementById("storage-usage");
								usedSpace = usedSpace.toFixed(2);
								totalSize = totalSize.toFixed(2);
								storageUsageDOM.innerText = usedSpace + " " + sizeMeasure + " used out of " + totalSize + " GB";
			
				if (obj.file.length < 1) {
					console.debug("empty folder");
				}
				// the following codes are used to display, the path to active folder
				var files = obj.file;

					// sorting files array
					files.sort( (a,b)=>{
						
						if(a.name>b.name){
							return 1;

						} else{
							return -1;
						}

					} );
					

				previousDir = obj.parentDir;
				currentDir = obj.currentDir;
				console.log(currentDir);
				fileexplorerbrowser.setAttribute("oncontextmenu", "contextmenuExplorer(event)");
			
						// remove all previous childs.
						while (fileexplorerbrowser.lastChild) {
							fileexplorerbrowser.removeChild(fileexplorerbrowser.lastChild);
						}
			
					
				
				// do for folder
				for (var i = 0; i < files.length; i++) {
					
					if( files[i].isDir == 1 ){
			
						var file = document.createElement("div");
							file.setAttribute("id", files[i].id);
							file.setAttribute("class", "fileexplorer-explorer-browser-file");
							file.setAttribute("onclick", "clickFile(event)");
							file.setAttribute("name", files[i].name);
							file.setAttribute("size", files[i].fileSize);
							file.setAttribute("type", files[i].filetype);
							
								file.setAttribute("ondblclick", "dblClikFolder(event)");
								file.setAttribute("oncontextmenu", "contextmenuFolder(event)");
							
						var fileIcon = document.createElement("img");
							fileIcon.setAttribute("id", files[i].id);
							fileIcon.setAttribute("name", files[i].name);
							fileIcon.setAttribute("size", files[i].fileSize);
							fileIcon.setAttribute("type", files[i].filetype);
							fileIcon.setAttribute("dateCreated", files[i].dateCreated);
							fileIcon.setAttribute("isShared", files[i].isShared);
							fileIcon.setAttribute("class", "fileexplorer-explorer-browser-file-image");
			
								fileIcon.setAttribute("src", "folder.png");
			
			
						fileIcon.setAttribute("fid", files[i].id);
						var fileName = document.createElement("label");
							fileName.setAttribute("class", "fileexplorer-explorer-browser-file-name");
							fileName.innerHTML = files[i].name.split("/")[0];
			
						file.appendChild(fileIcon);
						file.appendChild(fileName);
						
						fileexplorerbrowser.appendChild(file);
			
						} // ends if the file is folder
					// last	
				}
				
				/////////////////////////////////////////////////////////////////////////////
			
			
				for (var i = 0; i < files.length; i++) {
					
					if(  files[i].isDir == 0 ){
					
					var file = document.createElement("div");
						file.setAttribute("id", files[i].id);
						file.setAttribute("class", "fileexplorer-explorer-browser-file");
						file.setAttribute("onclick", "clickFile(event)");
						file.setAttribute("name", files[i].name);
						file.setAttribute("size", files[i].fileSize);
						file.setAttribute("type", files[i].filetype);
						file.setAttribute("ondblclick", "dblClikFile(event)");
						file.setAttribute("oncontextmenu", "contextmenuFile(event)");
						
					var fileIcon = document.createElement("img");
						fileIcon.setAttribute("id", files[i].id);
						fileIcon.setAttribute("name", files[i].name);
						fileIcon.setAttribute("size", files[i].fileSize);
						fileIcon.setAttribute("type", files[i].filetype);
						fileIcon.setAttribute("dateCreated", files[i].dateCreated);
						fileIcon.setAttribute("isShared", files[i].isShared);
						fileIcon.setAttribute("class", "fileexplorer-explorer-browser-file-image");
						fileIcon.setAttribute("src", "file.png");
			
				fileIcon.setAttribute("fid", files[i].id);
				var fileName = document.createElement("label");
					fileName.setAttribute("class", "fileexplorer-explorer-browser-file-name");
					fileName.innerHTML = files[i].name;
			
				file.appendChild(fileIcon);
				file.appendChild(fileName);
				fileexplorerbrowser.appendChild(file);
				// last	
			
				} // ends file
			}
			}
			


			function backLoad(){
					if(  previousDir!=null){
						loadUploadedFile(""+previousDir);	
					}else{
						return;
					}

			}
// ***********************************************************************************************************************************


// for events on file explorer	

 function contextmenuExplorer(event){

 	event.preventDefault();
 	event.stopPropagation();
	
	
	unmarkSelectedFile(event.target);
	hiddeAllPopups();

 	explorerPopupMenu.style.top = event.clientY+"px";
 	explorerPopupMenu.style.left = event.clientX+"px";
 	explorerPopupMenu.style.display ="flex";

 }





  function contextmenuTrashExplorer(event){

 	event.preventDefault();
 	event.stopPropagation();
	
	
	unmarkSelectedFile(event.target);
	hiddeAllPopups();

 	explorerTrashPopupMenu.style.top = event.clientY+"px";
 	explorerTrashPopupMenu.style.left = event.clientX+"px";
 	explorerTrashPopupMenu.style.display ="flex";

 }


function clickExplorer(){
	hiddeAllPopups();
	unmarkSelectedFile(preCliked);

}

function dblclickExplorer(event){
	unmarkSelectedFile(event.target);
}

function clickFile(event){
	
	if(event.target.id==""){
		return;
	}
	event.stopPropagation();

	hiddeAllPopups();
	markSelectedFile(event.target);

}

 function dblClikFolder(event){
 	if(event.target.id==""){
		return;
	}
 	event.stopPropagation();
	hiddeAllPopups();
	markSelectedFile(event.target);
	loadUploadedFile( event.target.id );

 }

  function dblClikFile(event){
 	
 	if(event.target.id==""){
		return;
	}
 	
 	event.stopPropagation();
	hiddeAllPopups();
	markSelectedFile(event.target);
	//	loadUploadedFile( event.target.id );
 	
	hiddeAllPopups();

		//set name
		//set type
		//set size

	fileDownloadAttributeName.innerHTML = "<b>Name</b> "+preCliked.name;
	fileDownloadAttributeType.innerHTML = "<b>Type</b> "+preCliked.getAttribute('type');
	fileDownloadAttributeSize.innerHTML = "<b>Size</b> "+preCliked.getAttribute('size') + " bytes" ;


	fileDowloadPopupOverlay.style.display = "flex";
	fileDowloadPopup.style.display = "flex";




 }



 // *****************************************************************************************************************************************************************************************
 // *****************************************************************************************************************************************************************************************
 
 // function that listent contextmenu events

	 function contextmenuFile(event){
		 	if(event.target.id==""){
				return;
			}

		 	event.preventDefault();
		 	event.stopPropagation();

		 	hiddeAllPopups();
		 	markSelectedFile(event.target);

		 	filePopupMenu.style.top = event.clientY+"px";
		 	filePopupMenu.style.left = event.clientX+"px";
		 	filePopupMenu.style.display ="flex";
	 }


	 function contextmenuTrashedFile(event){
	 	

		 	if(event.target.id==""){
				return;
			}

		 	event.preventDefault();
		 	event.stopPropagation();

		 	hiddeAllPopups();
		 	markSelectedFile(event.target);

		 	trashedFilePopupMenu.style.top = event.clientY+"px";
		 	trashedFilePopupMenu.style.left = event.clientX+"px";
		 	trashedFilePopupMenu.style.display ="flex";
	 }

	 function contextmenuTheySharedFile(event){
	 	

		 	if(event.target.id==""){
				return;
			}

		 	event.preventDefault();
		 	event.stopPropagation();

		 	hiddeAllPopups();
		 	markSelectedFile(event.target);

		 	theySharedFilePopupMenu.style.top = event.clientY+"px";
		 	theySharedFilePopupMenu.style.left = event.clientX+"px";
		 	theySharedFilePopupMenu.style.display ="flex";

	 }

	 function contextmenuIsharedFile(event){
		 	if(event.target.id==""){
				return;
			}

		 	event.preventDefault();
		 	event.stopPropagation();

		 	hiddeAllPopups();
		 	markSelectedFile(event.target);

		 	shareCaller = "ishared";
		 	isharedFilePopupMenu.style.top = event.clientY+"px";
		 	isharedFilePopupMenu.style.left = event.clientX+"px";
		 	isharedFilePopupMenu.style.display ="flex";
	 }
	 
	 function contextmenuFolder(event){
		 	if(event.target.id==""){
				return;
			}

		 	event.preventDefault();
		 	event.stopPropagation();

		 	hiddeAllPopups();
		 	markSelectedFile(event.target);

		 	folderPopupMenu.style.top = event.clientY+"px";
		 	folderPopupMenu.style.left = event.clientX+"px";
		 	folderPopupMenu.style.display ="flex";
	 }

// *****************************************************************************************************************************************************************************************
 // *****************************************************************************************************************************************************************************************
 


 function markSelectedFile(file){
	
	console.log("inside mark selected file."); 	

	if(preCliked!=undefined){
		preCliked.style.backgroundColor="unset";
	} 
	preCliked = file;


  fileExplorerType.innerHTML = preCliked.getAttribute('type');

		sizeInNumber = Number( preCliked.getAttribute('size') );
		sizeMeasure = "";
				if(sizeInNumber> 1000000000 ){
					sizeInNumber/= 1000000000;
					sizeMeasure = "GB";
				}
				else if( sizeInNumber> 1000000 ){
					sizeInNumber/= 1000000;
					sizeMeasure = "MB";
				}

				else if( sizeInNumber > 1000 ){
					sizeInNumber/= 1000;
					sizeMeasure = "KB";
				}

				else {
					sizeMeasure = "Byte";
				}

		sizeInNumber =sizeInNumber.toFixed(2);
 		fileExplorerSize.innerHTML = sizeInNumber+" "+sizeMeasure;
  
 
  if (preCliked.getAttribute('isshared')==1) {
  		fileExplorerShared.innerHTML = "Shared";
  	} else{
  	  	fileExplorerShared.innerHTML = "Not Shared";	
  	}


	console.log(preCliked);
	preCliked.style.backgroundColor="grey";
 }

function unmarkSelectedFile(){
		if(preCliked!=undefined){
				preCliked.style.backgroundColor="unset";
				preCliked=undefined;

			  fileExplorerType.innerHTML = "";
			  fileExplorerSize.innerHTML = "";
			  fileExplorerShared.innerHTML ="";					
		}


}

function hiddeAllPopups(){

 	filePopupMenu.style.display = "none";
 	trashedFilePopupMenu.style.display = "none";
 	isharedFilePopupMenu.style.display = "none";
	theySharedFilePopupMenu.style.display = "none";
 	
 	folderPopupMenu.style.display = "none";
	explorerPopupMenu.style.display = "none";
	explorerTrashPopupMenu.style.display="none";

 }


//******************************************************************************************************************************************************************************************
// **************************************************************************************************************************************************************************************
// function used to create new Folder

			
	function createFolder(){

		var createFolderPopupOoverlayDOM = document.getElementById('create-folder-popup-overlay');
		var createFolderPopupDOM = document.getElementById('create-folder-popup');
		var createFolderInputDOM = document.getElementById('create-folder-popup-content-input');

		createFolderPopupOoverlayDOM.style.display = "block";
		createFolderPopupDOM.style.display = "flex";
		createFolderInputDOM.focus();
	}

	function createFolderFinal(){

		var createFolderInputDOM = document.getElementById('create-folder-popup-content-input');
		
		var createFolderAjax = new XMLHttpRequest();
				
			createFolderAjax.onreadystatechange = function(){
				if( createFolderAjax.readyState==4 && createFolderAjax.status==200 ){

					var result =  parseInt(createFolderAjax.responseText);


					if( result==1 ){
						console.log("Folder created");
						cancelCreateFolder();
						loadUploadedFile(currentDir);
					}else{
						console.log("Faild to create folder");
						alert("Faild to create folder"); // change to custom alert.
					}

				}else{
				}

			}

			var parentID = currentDir;
			var name = createFolderInputDOM.value;
			console.log("Creating folder "+name);
			console.log("Inside "+parentID);

			createFolderAjax.open("GET","../create/createFolder.php?name="+name+"&parentID="+parentID ,true);
			createFolderAjax.send();

	}

	function cancelCreateFolder(){

		var createFolderPopupOoverlayDOM = document.getElementById('create-folder-popup-overlay');
		var createFolderPopupDOM = document.getElementById('create-folder-popup');
		var createFolderInputDOM = document.getElementById('create-folder-popup-content-input');

		createFolderInputDOM.value="";
		createFolderPopupOoverlayDOM.style.display = "none";
		createFolderPopupDOM.style.display = "none"; 
		
		}
 
// **************************************************************************************************************************************************************************************
//******************************************************************************************************************************************************************************************


// popup menu action listeners



function clickListenerDownload(){

 	
	hiddeAllPopups();

	//set name
	//set type
	//set size
fileDownloadAttributeName.innerHTML = "<b>Name</b> "+preCliked.name;
fileDownloadAttributeType.innerHTML = "<b>Type</b> "+preCliked.getAttribute('type');
fileDownloadAttributeSize.innerHTML = "<b>Size</b> "+preCliked.getAttribute('size') + " bytes" ;


	fileDowloadPopupOverlay.style.display = "flex";
	fileDowloadPopup.style.display = "flex";




} 


function downloadFileFinal(){

	console.log("downloading file....");
	var fid =preCliked.getAttribute("id");
	hiddeAllPopups();
	window.open("download.php?id="+fid);

	cancelFileDownload();


}

function cancelFileDownload(){

	fileDowloadPopupOverlay.style.display = "none";
	fileDowloadPopup.style.display = "none";





}

// ****************************************************************************************************************************************************************************************
// ****************************************************************************************************************************************************************************************
// Function used to rename file/folder


	var  renameFilePopupOverlay= document.getElementById('rename-file-popup-overlay');
	var  renameFilePopup = document.getElementById('rename-file-popup');
	var  renameFilePopupContentInput= document.getElementById('rename-file-popup-content-input');
	 		 
	 		
	function clickListenerRename(){


		var  renameFilePopupContentInput= document.getElementById('rename-file-popup-content-input');
		var  renameFilePopupOverlay= document.getElementById('rename-file-popup-overlay');
		var  renameFilePopup = document.getElementById('rename-file-popup');
			renameFilePopupOverlay.style.display="block";
			renameFilePopup.style.display="flex";

			renameFilePopupContentInput.focus();
			renameFilePopupContentInput.value=preCliked.getAttribute("name");


			hiddeAllPopups();

		}

	function renameFileFinal(){
 		
 		var  renameFilePopupContentInput= document.getElementById('rename-file-popup-content-input');
 		var newName = renameFilePopupContentInput.value;

 			var renameFileAjax = new XMLHttpRequest();
 				renameFileAjax.onreadystatechange = function(){
 					
 					if ( renameFileAjax.readyState==4 && renameFileAjax.status==200 ) {
 						console.log(renameFileAjax.responseText);
 						var result = parseInt( renameFileAjax.responseText );
 							if(result==1){
 								calcelFileRename();
 								loadUploadedFile( currentDir );

 							}else{
 								alert("Faild to rename file.");
 							}
 						console.log("value is "+result);
 					}
 				}	
 				
 				var fileId = preCliked.getAttribute('fid');
 				renameFileAjax.open("GET", "../misc/rename.php?id="+fileId+"&newname="+newName ,true);
 				renameFileAjax.send();
 }
 
 	function calcelFileRename(){
	 	var  renameFilePopupOverlay= document.getElementById('rename-file-popup-overlay');
		var  renameFilePopup = document.getElementById('rename-file-popup');
		var  renameFilePopupContentInput= document.getElementById('rename-file-popup-content-input');
	 		
	 		renameFilePopupContentInput.value="";
			renameFilePopupOverlay.style.display="none";
			renameFilePopup.style.display="none";
}
// ****************************************************************************************************************************************************************************************
// **************************************************************************************************************************************************************************************** 






// ****************************************************************************************************************************************************************************************
// ****************************************************************************************************************************************************************************************
// functions used for clipboared
		var copycutSource;
		var copycutType;
		var copycutDestination;

		function clickListenerCopy(){
			
			hiddeAllPopups();
			copycutType = "copy";
			copycutSource = preCliked.getAttribute('fid');

			console.log( copycutSource + "added to clopboard for "+copycutType );

		} 


		function clickListenerCut(){
			hiddeAllPopups();
			copycutType = "cut";
			copycutSource = preCliked.getAttribute('fid');
			console.log( copycutSource + "added to clopboard for "+copycutType );
		} 

// ***************************************************************************************************************************************************************************************
// ***************************************************************************************************************************************************************************************







//******************************************************************************************************************************************************************************************
//******************************************************************************************************************************************************************************************

//functions used to send a file to trash.

	function clickListenerTrash(){

		hiddeAllPopups();

		 	var trashFilePopupLayout = document.getElementById('trash-file-popup-overlay');
	 		var trashFilePopup = document.getElementById('trash-file-popup');

	 			trashFilePopupLayout.style.display="block";
	 			trashFilePopup.style.display="flex";
	 			
	}

	function trashFileFinal(){

			var trashFilePopupLayout = document.getElementById('trash-file-popup-overlay');
	 		var trashFilePopup = document.getElementById('trash-file-popup');

	 		var trashFileAjax = new XMLHttpRequest();
	 			trashFileAjax.onreadystatechange = function(){
	 				if ( trashFileAjax.readyState==4 && trashFileAjax.status==200 ) {

	 						var result = parseInt( trashFileAjax.responseText );
	 						if (result==1) {
	 							console.log("the specified file is sent to trash");
	 							calcelTrashingFile();
	 							loadUploadedFile(currentDir);
	 						} else{
	 							console.log("Unable to delete");
	 						}
	 				}
	 			}

	 			
	 			var fileId = preCliked.getAttribute('fid');
	 				console.log("Moving files identified by "+fileId );

	 			trashFileAjax.open('GET', "../delete/trash.php?id="+fileId,true);
	 			trashFileAjax.send();
	 			
	}

	function calcelTrashingFile(){
			
	 		var trashFilePopupLayout = document.getElementById('trash-file-popup-overlay');
	 		var trashFilePopup = document.getElementById('trash-file-popup');

	 			trashFilePopupLayout.style.display="none";
	 			trashFilePopup.style.display="none";

	}

	function clickListenerRestore(){
			
	 		var restoreFileAjax = new XMLHttpRequest();
	 			restoreFileAjax.onreadystatechange = function(){
	 				if ( restoreFileAjax.readyState==4 && restoreFileAjax.status==200 ) {

	 						var result = parseInt( restoreFileAjax.responseText );
	 						if (result==1) {
	 							console.log("the specified file is sent to trash");
	 							calcelTrashingFile();
	 							loadTrashedFiles();
	 							hiddeAllPopups();
	 						} else{
	 							console.log("Unable to delete");
	 						}
	 				}
	 			}

	 			
	 			var fileId = preCliked.getAttribute('fid');
	 				console.log("Moving files identified by "+fileId );

	 			restoreFileAjax.open('GET', "../delete/restore.php?id="+fileId,true);
	 			restoreFileAjax.send();

	}

	function emptyTrashBin(){
	 
	 	var emptyTrashAjax = new XMLHttpRequest();
	 			emptyTrashAjax.onreadystatechange = function(){
	 				if ( emptyTrashAjax.readyState==4 && emptyTrashAjax.status==200 ) {

	 						var result = parseInt( emptyTrashAjax.responseText );
	 						if (result==1) {
	 							console.log("Trash bin empitied");
	 							calcelTrashingFile();
	 							loadTrashedFiles();
	 							hiddeAllPopups();
	 						} else{
	 							console.log("Unable to empty recycle bin");
	 						}
	 				}
	 			}

	 			emptyTrashAjax.open('GET', "../delete/emptyBin.php",true);
	 			emptyTrashAjax.send();

	}

//******************************************************************************************************************************************************************************************
//******************************************************************************************************************************************************************************************




// listeners on folder events

function clickListenerOpen(){
		
		hiddeAllPopups();
		loadUploadedFile( preCliked.getAttribute('fid') );

}



// *******************************************************************************************************************************************************************************************
// funcrions to permanenltly delete file

	var deleteSource = "";
	function clickListenerDeleteForever(source){

		hiddeAllPopups();

		deleteSource = source;
		var deleteFilePopupOverlay = document.getElementById("delete-file-popup-overlay");
		var deleteFilePopup = document.getElementById("delete-file-popup");
		
		deleteFilePopupOverlay.style.display = "block";
		deleteFilePopup.style.display = "flex";
		
	}

	function deleteFileForeverFinal(){
		
		hiddeAllPopups();
		var deleteFilePopupOverlay = document.getElementById("delete-file-popup-overlay");
		var deleteFilePopup = document.getElementById("delete-file-popup");
			
			deletePermanentlyAjax = new XMLHttpRequest();
			
			deletePermanentlyAjax.onreadystatechange = function(){
				
				if ( deletePermanentlyAjax.readyState==4 && deletePermanentlyAjax.status==200 ) {
					console.log("seems deleted");
					var res = parseInt(deletePermanentlyAjax.responseText);
						if (res==1) {
							cancelDeleteFileForever();
							if (deleteSource=="u") {
								loadUploadedFile(currentDir);
							}else{
								loadTrashedFiles();
							}
							
						} else{
							console.error( deletePermanentlyAjax.responseText );
						}
				}

			}

				fileId = preCliked.getAttribute('fid');
				deletePermanentlyAjax.open("GET","../delete/delete.php?id="+fileId,true)
				deletePermanentlyAjax.send();
	}

	function cancelDeleteFileForever(){
		
		hiddeAllPopups();
		var deleteFilePopupOverlay = document.getElementById("delete-file-popup-overlay");
		var deleteFilePopup = document.getElementById("delete-file-popup");
		
		deleteFilePopupOverlay.style.display = "none";
		deleteFilePopup.style.display = "none";

	}

//*******************************************************************************************************************************************************************************************



// listeners on explorer 
function clickListenerPaste(){

	var copycutDestination = currentDir;
	pasteAjax = new XMLHttpRequest();
		pasteAjax.onreadystatechange = function(){

				if (pasteAjax.readyState==4 && pasteAjax.status==200) {
					hiddeAllPopups();
					loadUploadedFile(currentDir);
				}

		}

	if (copycutType=="copy") {
		console.log("copying file");
		pasteAjax.open("GET", "../misc/copy.php?source="+copycutSource+"&destination="+copycutDestination,true);
	}

	else if ( copycutType=="cut" ) {
		console.log("Moving file....");
		var getUrl = "../misc/move.php?source="+copycutSource+"&destination="+copycutDestination;

		console.log(getUrl);
		pasteAjax.open("GET", getUrl ,true);
	}
	pasteAjax.send();
}

function clickListenerRefresh(){
	hiddeAllPopups();
	loadUploadedFile( currentDir );	
}

function clickListenerRefreshTrash (){
	hiddeAllPopups();
	loadTrashedFiles();
}


//********************************************************************************************************************************************************************************************
// Functiuons used to upload file.
	
	var uploadAjax = new XMLHttpRequest();

	function uploadFile(){
		console.log("opening file uploader");

		var fileSelcetorButtonDOM  = document.getElementById("upload-file-popup-selectfile");
		var fileUploadingLabelDOM = document.getElementById("uploading-label");
		var fileUploadProgress = document.getElementById("upload-progress"); 
		var fileUploadSendButton = document.getElementById("upload-file-popup-buttons-upload");

		fileSelcetorButtonDOM.style.display="block";
		fileUploadSendButton.style.display = "inline";

		fileUploadingLabelDOM.style.display="none";
		fileUploadProgress.style.display="none";
	

		var fileUploadPopupOverlay = document.getElementById('upload-file-popup-overlay');
		var fileUploadPopup = document.getElementById('upload-file-popup');

			fileUploadPopupOverlay.style.display = "block";
			fileUploadPopup.style.display = "block";
			
			var fileInput = document.getElementById('upload-file-popup-input');
			var fileSelectButton = document.getElementById('upload-file-popup-selectfile');
	
			fileInput.files[0].name=undefined;
			fileSelectButton.innerHTML ="Choose file...";
	}
 

	function uploadFileFinal(){
		console.log("Now sending file");
		var fileSelcetorButtonDOM  = document.getElementById("upload-file-popup-selectfile");
		var fileUploadingLabelDOM = document.getElementById("uploading-label");
		var fileUploadProgress = document.getElementById("upload-progress"); 
		var fileUploadSendButton = document.getElementById("upload-file-popup-buttons-upload");

		fileSelcetorButtonDOM.style.display="none";
		fileUploadSendButton.style.display="none";

		fileUploadingLabelDOM.style.display="inline";
		fileUploadProgress.style.display="block";


		
		uploadAjax.onreadystatechange = function(){

			if (uploadAjax.readyState==4 && uploadAjax.status==200) {
				res =  parseInt( uploadAjax.responseText );
				if (res==1) {
					console.log("File Secesfully uploaded");
					loadUploadedFile(currentDir);

							var fileUploadPopupOverlay = document.getElementById('upload-file-popup-overlay');
							var fileUploadPopup = document.getElementById('upload-file-popup');

							fileUploadPopupOverlay.style.display = "none";
							fileUploadPopup.style.display = "none";
							fileUploadProgress.style.width="0%";

				} else{
					
					alert("Faild to upload file."); // tell upload is not seccuss
					cancelFileUpload(); // close the file upload popup
				}

			}
		}
		uploadAjax.upload.addEventListener('progress', function(e){
			

			var percent =  Math.ceil( (e.loaded/e.total) *100 );

			fileUploadingLabelDOM.innerText = "Uploading "+percent+" %";
			fileUploadProgress.style.width=percent+"%";
			//console.log( );
			//console.log( Math.ceil(e.loaded/e.total) * 100 + '%');
		}, true);



		var fileInput = document.getElementById('upload-file-popup-input');
			file = fileInput.files[0];
		
		var fd = new FormData();
			fd.append("file",file);
			fd.append("parentID",currentDir);
		

			uploadAjax.open("POST","../create/upload.php",true);
			uploadAjax.send(fd);

	}	

	function cancelFileUpload(){

		uploadAjax.abort();
		var fileUploadPopupOverlay = document.getElementById('upload-file-popup-overlay');
		var fileUploadPopup = document.getElementById('upload-file-popup');

			fileUploadPopupOverlay.style.display = "none";
			fileUploadPopup.style.display = "none";
		
			console.log("Canceling file upload");
	}

	function selectedFileChange(){

		console.log("selected file changed ");

		var fileInput = document.getElementById('upload-file-popup-input');
		var fileSelectButton = document.getElementById('upload-file-popup-selectfile');
		var fileUploadButton = document.getElementById('upload-file-popup-buttons-upload');


		if ( fileInput.files.length > 0 ) {
			var selectedFileName = fileInput.files[0].name;
				fileSelectButton.innerHTML=selectedFileName;
				fileUploadButton.style.cursor = "pointer";
				fileUploadButton.style.backgroundColor = "#0074e8";
				fileUploadButton.removeAttribute("disabled");
				
				console.log( "File name : "+selectedFileName );
		}
	}

// *******************************************************************************************************************************************************************************************