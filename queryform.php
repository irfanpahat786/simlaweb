<section class="common-query-section">
  <div class="container">
    <div class="query-form">
      <h1 class="slideanim">Queries</h1>
      <p class="slideanim">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
	  
	  <form class="form-horizontal" id="form-query" method="post" name="queryform" action="queryformpost.php">
        <div class="form-group">
          <div class="col-sm-6">
            <input type="text" class="form-control" placeholder="Name" name="username" id="username" required>
          </div>
          <div class="col-sm-6">
            <select class="selectpicker" name="dropdownvalue">
              <option>Mustard</option>
              <option>Ketchup</option>
              <option>Relish</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-6">
            <input type="email" class="form-control" placeholder="E-mail" name="useremail" id="useremail" required>
          </div>
          <div class="col-sm-6">
            <input type="text" class="form-control" placeholder="Phone no" name="userphone" id="userphone" required>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
            <textarea class="form-control" placeholder="Query Details" name="userquerydetails" id="userquerydetails" maxlength="500">

</textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
            <button type="submit" name="query" class="btn btn-default submit-query">Submit Query</button>
          </div>
        </div>
      </form>
	  
	   </div>
  </div>
</section>