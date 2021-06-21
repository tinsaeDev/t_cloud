function showUploadedFiles(responseText) {
	var obj = JSON.parse(responseText);
	// show the current directory
	pathDOM = document.getElementById("fileexplorer-path");
	path = obj.folderPath.split("/home/tcloud/uploaded_files/")[1];
	path = path.split(obj.user)[1];
    pathDOM.innerText = path;

                    // storage usage
                    totalSize = obj.totalSpace;
                    totalSize = Math.round(totalSize / 1000000000);
                    usedSpace = obj.usedSpace;
                    var sizeMeasure = "";
                    if (usedSpace > 1000000000) {
                        usedSpace = Math.round(usedSpace / 1000000000);
                        sizeMeasure = "GB";
                    }
                    else if (usedSpace > 1000000) {
                        usedSpace = Math.round(usedSpace / 1000000);
                        sizeMeasure = "MB";
                    }
                    else if (usedSpace > 1000) {
                        usedSpace = Math.round(usedSpace / 1000);
                        sizeMeasure = "KB";
                    }
                    else {
                        usedSpace = Math.round(usedSpace);
                        sizeMeasure = "Byte";
                    }
                    var storageUsageDOM = document.getElementById("storage-usage");
                    storageUsageDOM.innerText = usedSpace + " " + sizeMeasure + " used out of " + totalSize + " GB";

	if (obj.file.length < 1) {
		console.debug("empty folder");
	}
	// the following codes are used to display, the path to active folder
	var files = obj.file;
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
                fileName.innerHTML = files[i].name;

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
