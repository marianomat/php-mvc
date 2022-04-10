
<h1>Register</h1>
<form action="/register" method="post">
    <div class="row">
        <div class="col">
            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input name="firstName" type="text"  class="form-control">
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input name="lastName" type="text"  class="form-control">
            </div>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input name="email" type="text" class="form-control" >
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input name="password" type="password" class="form-control" >
    </div>
    <div class="mb-3">
        <label class="form-label">Confirm password</label>
        <input name="confirmPassword" type="password" class="form-control" >
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>