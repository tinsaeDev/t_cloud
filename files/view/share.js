


	var shareFilePopupOverlay;
	var shareFilePopup;
	var shareFileHeaderStatus;
	var shareFileUsersList;
	var shareFileUserInput;

	var shareStatus;

	var alreadyAddedUsers;
	var newlyAddedUsers = new Array();
	var removedUsers = new Array();


	function initShare(){
			
		 shareFilePopupOverlay = document.getElementById('share-file-popup-overlay');
		 shareFilePopup = document.getElementById('share-file-popup');
		 shareFileHeaderStatus = document.getElementById('share-file-popup-header-sharestatus');
		 shareFileUsersList = document.getElementById('share-file-popup-userslist');
		 shareFileUserInput = document.getElementById('share-file-popup-adduser-input');
	}


	// used to add the username 
	function addSharedWithUser(){
		

		// ignore if empty
		inputText  = shareFileUserInput.value;
		if (inputText =="" ) {
			return;
		}


		// given user is found data recieved from server and visible, ignored.
		if ( alreadyAddedUsers.includes(inputText) && !removedUsers.includes(inputText) ) {
			console.log('given user is found data recieved from server and visible, ignored.');
			return;
		}





		// given username is found in data recived from server, but not visible, now visible.
		if ( removedUsers.includes(inputText) ) {
			
			removedUsers.splice( removedUsers.indexOf( inputText ),1 );
			console.log("given username is found in data recived from server, but not visible, now visible.");
			createUserDOM(inputText);
			return;

		}


		// given user is previously added and visible, ignored
		if ( newlyAddedUsers.includes(inputText) ) {
			console.log('given user is previously added and visible, ignored');
			return;
		}


		// given user us tougth to be OK, added to new users.
		newlyAddedUsers.push( inputText );
		createUserDOM(inputText);


		}

	function createUserDOM(user){
	
			var userDiv = document.createElement("div");
				userDiv.setAttribute("class","share-file-popup-userslist-user");
				userDiv.setAttribute("ID",user);

				var userLabel = document.createElement("label");
					userLabel.setAttribute("class","share-file-popup-userslist-username");
					userLabel.innerHTML = user;

				var userRemove = document.createElement("button");
					userRemove.setAttribute("class","share-file-popup-userslist-remove");
					userRemove.setAttribute("onclick","removeSharedWithUser( \""+user+ "\")");
					userRemove.innerHTML = "Remove";


				userDiv.appendChild(userLabel);
				userDiv.appendChild(userRemove);
				shareFileUsersList.appendChild(userDiv);
				shareFileUsersList.scrollTop = shareFileUsersList.scrollTopMax;
	
				console.log('user added');
				shareFileUserInput.value="";
				shareFileUserInput.focus();	
	}

	function removeSharedWithUser(user){


		// remove already added user
		if ( alreadyAddedUsers.includes(user) && !removedUsers.includes(user) ) {
			
			removedUsers.push( user );
			
			console.log(" removing existing users :"+user);

			var userElem = document.getElementById(user);
			shareFileUsersList.removeChild( userElem );

			return;
		}

		// remove newly added user
		if ( newlyAddedUsers.includes(user)  ) {
			newlyAddedUsers.splice( newlyAddedUsers.indexOf( user ) , 1 );	
				console.log("removing new users :"+user);

			var userElem = document.getElementById(user);
			shareFileUsersList.removeChild( userElem );

			return;
		}	

		console.log("logic error");
	}

	function saveSharedWithUsers(){

			var jsob = new Object();

			

			if ( newlyAddedUsers.length==0 && alreadyAddedUsers.length==removedUsers.length || shareFileHeaderStatus.checked == false   ) {
				jsob.status = false;
			}

			else{
				jsob.status = true;
			}//



			jsob.newlyAdded = newlyAddedUsers;
			jsob.newlyAddedSize = newlyAddedUsers.length;

			jsob.removed = removedUsers;
			jsob.removedSize = removedUsers.length;

			jsob.fileId = preCliked.getAttribute('fid');
				
				console.log( "new :"+ newlyAddedUsers.length  );
				console.log( "already :" +alreadyAddedUsers.length);
				console.log( "removed :" + removedUsers.length);

				console.log(jsob);
			
			var json = JSON.stringify( jsob );
			

			saveSharedWithUsersAjax = new XMLHttpRequest();
			saveSharedWithUsersAjax.onreadystatechange = function(){

				if (saveSharedWithUsersAjax.readyState==4 && saveSharedWithUsersAjax.status==200 ) {

					res = parseInt(saveSharedWithUsersAjax.responseText);
					if (res==1) {
						console.log("*********** Sharing saved ***********");
						cancelSharedWithUsers();

						alreadyAddedUsers = new Array();
						removedUsers = new Array();
						newlyAddedUsers = new Array();
							
							if (shareCaller=="uploaded"){
								loadUploadedFile(currentDir);
							}
							else if (shareCaller=="ishared") {
								loadSharedFile();
							}
							

					} else{
						alert("Faild to share, try again latter");
					}
				}

			}

			saveSharedWithUsersAjax.open("GET","../misc/shareFile.php?json="+json,true);
			saveSharedWithUsersAjax.send();

	}
	
	function cancelSharedWithUsers(){

		// remove all users fron UI.
		while( shareFileUsersList.lastChild ){
			shareFileUsersList.removeChild( shareFileUsersList.lastChild );
		}


		// empty array 
		newlyAddedUsers.splice( 0,newlyAddedUsers.length );
		removedUsers.splice( 0,newlyAddedUsers.length ); 
		alreadyAddedUsers.splice(0,alreadyAddedUsers.length );


		shareFileUserInput.value ="";

		// hede sharer popup
	 	shareFilePopupOverlay.style.display = "none";
		shareFilePopup.style.display = "none";

	}

	function shareFileHeaderStatusChanged(){
		console.log("Status change detected");
		if (!shareFileHeaderStatus.checked) {
			shareFileUsersList.style.opacity=.3;
		} else{
			shareFileUsersList.style.opacity=1;
		}
	}

	function clickListenerShare(){
		
		hiddeAllPopups();
		loadAreadyAddedUsers();

	} 

// fetch list of users, file is shared with.
	function loadAreadyAddedUsers(){

		fileID = preCliked.getAttribute("fid");
			loadAreadyAddedUsersAjax = new XMLHttpRequest();
			loadAreadyAddedUsersAjax.onreadystatechange = function(){

				if ( loadAreadyAddedUsersAjax.readyState==4 && loadAreadyAddedUsersAjax.status==200 ) {
					var json = loadAreadyAddedUsersAjax.responseText;
					var jsob = JSON.parse(json);
					showSharingPopup(jsob);
				}
			}

			loadAreadyAddedUsersAjax.open("GET","viewIShared.php?id="+fileID,true);
			loadAreadyAddedUsersAjax.send();
	}


// openes a  popup, 
	function showSharingPopup(obj){


			console.log("showing from server");
			console.log(obj);

			shareStatus = obj.shareStatus;			

			// if file is not shared with anyone.

			if (shareStatus) {
				console.log("File sharing is turned on from server, ticking...");

				
				shareFileHeaderStatus.checked = true;
				
				alreadyAddedUsers = obj.sharedwith;

				for(var i=0; i < alreadyAddedUsers.length; i++ ){
							createUserDOM(alreadyAddedUsers[i]);
				}

			} 

			else{

				shareFileHeaderStatus.checked = false;
				console.log("File sharing is turned off from server, ticking...");
				alreadyAddedUsers = new Array();
		}

		 	shareFilePopupOverlay.style.display = "block";
			shareFilePopup.style.display = "block";

	}



// *********************************************************************************************************************************
// *********************************************************************************************************************************
// Load I shared files

			var loadSharedAjax = new XMLHttpRequest();
			
			loadSharedAjax.onreadystatechange = function(){
						if( loadSharedAjax.status == 200 && loadSharedAjax.readyState==4 ){
							showSharedFiles( loadSharedAjax.responseText  );
						}
			}




			function loadSharedFile(){


		 			shareCaller = "ishared";
					fileExplorerInfo.style.display = "none";
					hiddeAllPopups();
					loadSharedAjax.open("GET","sharedByMe.php",true);
					loadSharedAjax.send();
			}

			function showSharedFiles(responseText) {

				var obj = JSON.parse(responseText);
					
					if ( obj.files.length<1 ) {
						
					}

				var files = obj.files;
				previousDir = obj.parentDir;
				currentDir = obj.currentDir;


					fileexplorerbrowser.setAttribute("oncontextmenu",null);
					
					// remove all previous childs.
					while( fileexplorerbrowser.lastChild ){
						fileexplorerbrowser.removeChild( fileexplorerbrowser.lastChild );
					}


					for( var i = 0; i < files.length; i++  ){
				
						var file = document.createElement("div");

							file.setAttribute("id", files[i].id );
							file.setAttribute("class","fileexplorer-explorer-browser-file");
							file.setAttribute("onclick","clickFile(event)");
							file.setAttribute("oncontextmenu","contextmenuIsharedFile(event)");
									
						

						var fileIcon = document.createElement("img");
							fileIcon.setAttribute("id",files[i].id);
							fileIcon.setAttribute("class","fileexplorer-explorer-browser-file-image");
								
								if( files[i].isDir==1 ){
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



// *********************************************************************************************************************************
// *********************************************************************************************************************************



// *********************************************************************************************************************************
// *********************************************************************************************************************************
// Load They shared files

			var loadTheySharedAjax = new XMLHttpRequest();
			
			loadTheySharedAjax.onreadystatechange = function(){
						if( loadTheySharedAjax.status == 200 && loadTheySharedAjax.readyState==4 ){
							showTheySharedFiles( loadTheySharedAjax.responseText  );
						}
			}


			function loadTheySharedFile(){

					fileExplorerInfo.style.display = "none";
					hiddeAllPopups();

					loadTheySharedAjax.open("GET","sharedForMe.php",true);
					loadTheySharedAjax.send();
			}

			function showTheySharedFiles(responseText) {

				var obj = JSON.parse(responseText);
					

				var files = obj.files;
				
					fileexplorerbrowser.setAttribute("oncontextmenu",null);
					
					// remove all previous childs.
					while( fileexplorerbrowser.lastChild ){
						fileexplorerbrowser.removeChild( fileexplorerbrowser.lastChild );
					}


					for( var i = 0; i < files.length; i++  ){
				
						var file = document.createElement("div");

							file.setAttribute("id", files[i].id );
							file.setAttribute("class","fileexplorer-explorer-browser-file");
							file.setAttribute("onclick","clickFile(event)");
							
							file.setAttribute("oncontextmenu","contextmenuTheySharedFile(event)");
									
						

						var fileIcon = document.createElement("img");
							fileIcon.setAttribute("id",files[i].id);
							fileIcon.setAttribute("class","fileexplorer-explorer-browser-file-image");
							
							fileIcon.setAttribute("src","file.png");
												

							fileIcon.setAttribute("fid",files[i].id);

						var fileName = document.createElement("label");
							fileName.setAttribute("class","fileexplorer-explorer-browser-file-name");
							fileName.innerHTML = files[i].name;

							file.appendChild(fileIcon);
							file.appendChild(fileName);
							
							fileexplorerbrowser.appendChild(file);

					}

			}



// *********************************************************************************************************************************
// *********************************************************************************************************************************
