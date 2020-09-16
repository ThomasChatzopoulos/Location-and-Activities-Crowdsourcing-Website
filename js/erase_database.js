function erase_db(){
	if(confirm("Αll data of database will be deleted. You are sure?")){
	  $.ajax({
			url: 'erase_database.php',
			dataType: 'text',
			cache: false,
			contentType: false,
			processData: false,
			type: 'post',
	    success: function (data) {
	      if(data=="Success"){
	        alert("Database successfully erased!");
	      }
				else if(data=="Fail") {
					alert("Failed ");
				}
	    },
		});
	}
	// else{
	// 	alert("OK");
	// }
}
