/***************************************************************
* paFileDB 3.6                                                 *
*                                                              *
* Author: PHP Arena <http://www.phparena.net>                  *
* File Version 3.6                                             *
* Copyright ©2005-2007 PHP Arena. All Rights Reserved.         *
*                                                              *
* THIS FILE MAY NOT BE REDISTRIBUTED.                          *
* For more information, please see the PHP Arena license at:   *
* http://www.phparena.net/license.html                         *
***************************************************************/

function openAjax() {
	try {
	  return new XMLHttpRequest();
	} catch (trymicrosoft) {
	  try {
		return new ActiveXObject("Msxml2.XMLHTTP");
	  } catch (othermicrosoft) {
		try {
		  return new ActiveXObject("Microsoft.XMLHTTP");
		} catch (failed) {
		  return false;
		}
	  }
	}
}

function rateFile(file, rating) {
	document.getElementById('submitButton').innerHTML = '<img src="'+img_dir+'/progress.gif" alt="Progress" />';
    req = openAjax();
    var url = "ajax.php?act=rate&file="+file+"&rating="+rating;
    req.open("get", url, true);
    req.onreadystatechange = handleRate;
    req.send('null');
    
}

function handleRate() {
    if(req.readyState == 4){
        document.getElementById('fileRating').innerHTML = req.responseText;
    }
}

function postComment(fileID) {
	var commentText;
	var tMCEused;
	if (typeof(tinyMCE) != "undefined") {
		tinyMCE.execInstanceCommand("comment", "mceFocus");
		commentText = tinyMCE.getContent();
		tMCEused = 1;
	} else {
		commentText = document.getElementById("comment").value;
		tMCEused = 0;
	}
	if (document.getElementById("subject").value == "" || commentText == "") {
		alert(comment_emptyfield);
		return false;
	}
	document.getElementById('status').innerHTML = '<img src="'+img_dir+'/progress.gif" alt="Progress" /> '+comment_wait;
	req = openAjax();
	var url = "ajax.php?act=postcomment&file="+fileID;
	req.open("post", url, true);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	req.onreadystatechange = handlePostComment;
	req.send("subject="+escape(document.getElementById("subject").value)+"&comment="+escape(commentText)+"&tMCEused="+tMCEused);
}

function handlePostComment() {
	if (req.readyState == 4) {
		document.getElementById("subject").value = "";
		document.getElementById("comment").value = "";
		document.getElementById('commentTables').innerHTML = document.getElementById('commentTables').innerHTML + req.responseText;
		document.getElementById('status').innerHTML = '';
		if (typeof(tinyMCE) != "undefined") {
			tinyMCE.setContent('');
		}
	}
}	

function deleteComment(commentID) {
	if (confirm(delete_comment_conf)) {
		req = openAjax();
		var url = 'ajax.php?act=deletecomment&comment='+commentID;
		req.open("get", url, true);
		req.onreadystatechange = handleDeleteComment;
		req.send('null');
	}
}

function handleDeleteComment() {
	if (req.readyState == 4) {
		document.getElementById("comment"+req.responseText).innerHTML = "";
	}
}

var oldDivContent;
var editCommentID = 0;
function editComment(commentID) {
	var tMCEused;
	if (editCommentID > 0) {
		cancelEdit(editCommentID);
	}
	if (typeof(tinyMCE) != "undefined") {
		tMCEused = 1;
	} else {
		tMCEused = 0;
	}
	req = openAjax();
	var url = 'ajax.php?act=editcomment&comment='+commentID+'&tMCEused='+tMCEused;
	req.open("get", url, true);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	req.onreadystatechange = handleEditComment;
	req.send('null');
	editCommentID = commentID;
}

function handleEditComment() {
	if (req.readyState == 4) {
		oldDivContent = document.getElementById("comment"+editCommentID).innerHTML;
		document.getElementById("comment"+editCommentID).innerHTML = req.responseText;
		if (typeof(tinyMCE) != "undefined") {
			tinyMCE.execCommand('mceAddControl', false, "commenttext"+editCommentID); 
		}
	}
}

function cancelEdit() {
	if (typeof(tinyMCE) != "undefined") {
		tinyMCE.execCommand( 'mceRemoveControl', true, "commenttext"+editCommentID);
	}
	document.getElementById("comment"+editCommentID).innerHTML = oldDivContent;
	editCommentID = 0;
}

function saveComment() {
	var commentText;
	var tMCEused;
	if (typeof(tinyMCE) != "undefined") {
		tinyMCE.execInstanceCommand("commenttext"+editCommentID, "mceFocus");
		commentText = tinyMCE.getContent();
		tMCEused = 1;
	} else {
		commentText = document.getElementById("commenttext"+editCommentID).value;
		tMCEused = 0;
	}
	if (document.getElementById("subject"+editCommentID).value == "" || commentText == "") {
		alert(comment_emptyfield);
		return false;
	}
	req = openAjax();
	var url = "ajax.php?act=savecomment&id="+editCommentID;
	req.open("post", url, true);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	req.onreadystatechange = handleSaveComment;
	req.send("&subject="+escape(document.getElementById("subject"+editCommentID).value)+"&comment="+escape(commentText)+"&tMCEused="+tMCEused);
}

function handleSaveComment() {
	if (req.readyState == 4) {
		if (typeof(tinyMCE) != "undefined") {
			tinyMCE.execCommand( 'mceRemoveControl', true, "commenttext"+editCommentID);
		}
		document.getElementById('comment'+editCommentID).innerHTML = req.responseText;
		editCommentID = 0;
	}
}
