//Set the CSRF header token for AJAX request validation
window.onload = function() {
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
}
//Function to return a list of marks
//the list can be based on an optional student_id list
//An attribute list is required 
//The attribute list can contain a list with values ('id', 'grade', 'student_id', 'student_remark', 'created_at', 'updated_at', 'exam_id', 'section_id', 'subject_id')
//ret_func is a callback function with the results
function getMarks({return_attributes=null, ret_func=null, filter_attribute=null}){
  var connectionActive = false;
  var data_out =  {return_attributes: return_attributes, filter_attribute: filter_attribute};

  //Call DB if sectionID is not null
  if (sectionID != "")
  {
    if(!connectionActive)
    {
      $.ajax({
        beforeSend: function(xhr)
        {
          connectionActive = true;
        },
        type:'POST',
        url: "/getMarks",
        data: data_out,
        success:function(data)
        {
          connectionActive = false;
          // console.log(data);
          ret_func(data);
        }
      });
    }
  }
}

//Function to return a list of student attributes (as specified in the list of string passed in as select_attributes) based on
//section DOM object which has value as the section id
//section id can be null. This will return a list of all students
//ret_func is a callback function with the results
//section==None returns nothing
function getSectionStudents({section=null, return_attributes=null, ret_func=null}){
  var connectionActive = false;
  var data_out =  {sectionID: $(section).val(), attributes: return_attributes};
  //Call DB if sectionID is not null
  if (sectionID != "")
  {
    if(!connectionActive)
    {
      $.ajax({
        beforeSend: function(xhr)
        {
          connectionActive = true;
        },
        type:'POST',
        url: "/getSectionStudents",
        data: data_out,
        // data: {sectionID:sectionID},
        success:function(data)
        {
          connectionActive = false;
          ret_func(data);
        }
      });
    }
  }
}

//Function to generate a table based on rows (object) which is an array of similar objects  where the table header is created using the header string array 
//and the table rows are created using the values for each object, the th_class(string) contains the class list for the thead and tb_class(string) contains 
//the class list for the table body and table_class(string) contains the class list for the table
function generateTable({rows=null, header=null, th_class='', tb_class='', tr_class='', td_class='', table_class='', table_id=''}){
  if(rows==null){
    return;
  }
  //Basic table structure
  var table = '<table class="'+table_class+'" id="'+table_id+'"><thead class="'+th_class+'"><tr class="'+tr_class+'">';
  console.log(Object.keys(rows[0]));
  for (let [key, value] of Object.entries(header)){
    console.log(value);
    table = table + '<td class="'+td_class+'">'+value+'</td>';
  }
  table = table + '</tr></thead><tbody class="'+tb_class+'">';

  //Iterate over rows
  for (let [key] of Object.entries(rows)) {
    // console.log(key, value);
    table = table + '<tr class="'+tr_class+'">';
    for (let [key1, value1] of Object.entries(rows[key])){
      table = table + '<td class="'+td_class+'">'+value1+'</td>';
    }
    table = table + '</tr>';
  }
  table = table + '</tbody></table>';
  // console.log(table);
  return table;
}

//Function to return a list of student attributes (as specified in the list of string passed in as select_attributes) based on criterion
//Criterion can be, a specific value of one or more of the attributes (for example id=5) and will be passed in 
//(as an array of key-value pairs, where the key is the attribute name and the value the attribute value) using select_attributes
//Criterion can also be a DOM object passed in as section to filter students based on section
//Attributes can be a list of string where string items can be
//name, id, fatherName, motherName, gender, address, contact, bloodGroup, rollNumber, birthCertificate, created_at, updated_at 
function getStudents({section=null, select_attributes=null, return_attributes}){
  where_clauses = [];
  //Convert key value object to array
  for (let [key, value] of Object.entries(select_attributes)) {
    where_clauses.push(key);
    where_clauses.push(value);
  }
  var data_out =  {sectionID: $(section).val(), attributes: return_attributes, where: where_clauses};
  var connectionActive = false;
  //Call DB if sectionID is not null
  if (sectionID != "")
  {
    if(!connectionActive)
    {
      $.ajax({
        beforeSend: function(xhr)
        {
          connectionActive = true;
        },
        type:'POST',
        url: "/getStudent",
        data: data_out,
        // data: {sectionID:sectionID},
        success:function(data)
        {
          connectionActive = false;
          console.log(data);

        }
      });
    }
  }
}

//Function to get subjects once a section has been selected
function getSectionSubjects(sectionID){
  console.log("yo");
  //Call DB if sectionID is not null
  if (sectionID != "")
  {
    let newPromise = new Promise((resolve, reject)=>
      {
        $.ajax({
          beforeSend: function(xhr)
          {
            connectionActive = true;
          },
          type:'POST',
          url: "/marks/getSubjects",
          data: {sectionID:sectionID},
          success:function(data)
          {
            if(data.msg.length > 0)
            { 
              console.log("asdf");             
              resolve(data);
            }
            else
            {
              
              reject("asdfsas");
            }
          }
        });
      }
    ).then(
      (val)=>console.log(val)
    ).catch(
      (error)=>console.log(error)
    );
  }
  else
  {
    return null;
  }
}