document.querySelector(".addBtn").addEventListener("click",newTask,false);
document.querySelector('ul').addEventListener("click", line,false);


function newTask(){
    /*if($("input").val() == null || $("input").val() == ''){
        alert ("Vous devez entrer une valeur");
    }

    // Create our new <li>
    let li= $("<li></li>");

    // Put our input into the <li>
    li.append($("input").val());
    li.append('<span class ="close">\u00D7</span>');

    //Put our <li> into our <ul>
    $("ul").append(li);


    // Click on a close button to hide the current list item
    let close = $(".close");
    for (let i = 0; i < close.length; i++) {
        close[i].onclick = function() {
            $(this).parent().hide();
        }
    }
}

// Mark the done task
function line(ev){
    if(ev.target.tagName == 'LI'){
        ev.target.classList.toggle('checked');
    }*/
    const uri = "/todolist/add";
    $.ajax({
        url:uri+'/ajaxP',
        type: "POST",
        dataType: "json",
        data: {
            'element': $("input").val()
        },
        async: true,
        success: function (data)
        {
            console.log(data.id)
            $("ul").append("<li><input type='hidden' id='"+data.id+"'>+value+<span class =\"close\">\u00D7</span></li>");//Append our new element to the list
        }
    });

}