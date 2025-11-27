@csrf

<div class="card shadow-sm mb-4">
    <div class="card-header bg-light fw-semibold">
        Personal Information
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">First Name</label>
                <input type="text" name="firstName" class="form-control"
                       value="{{ old('firstName', $person->firstName ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" name="lastName" class="form-control"
                       value="{{ old('lastName', $person->lastName ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Gender</label>
                <input type="text" name="gender" class="form-control"
                       value="{{ old('gender', $person->gender ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" name="dob" class="form-control"
                       value="{{ old('dob', $person->dob ?? '') }}">
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control"
                       value="{{ old('address', $person->address ?? '') }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Country</label>
                <input type="text" name="country" class="form-control"
                       value="{{ old('country', $person->country ?? '') }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">State</label>
                <input type="text" name="state" class="form-control"
                       value="{{ old('state', $person->state ?? '') }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">City</label>
                <input type="text" name="city" class="form-control"
                       value="{{ old('city', $person->city ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">ZIP</label>
                <input type="text" name="zip" class="form-control"
                       value="{{ old('zip', $person->zip ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">SSN</label>
                <input type="text" name="ssn" class="form-control"
                       value="{{ old('ssn', $person->ssn ?? '') }}">
            </div>
        </div>

    </div>
</div>

<!-- Account & Credentials -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-light fw-semibold">
        Account & Email Credentials
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email', $person->email ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Email Password</label>
                <input type="text" name="emailPass" class="form-control"
                       value="{{ old('emailPass', $person->emailPass ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">2FA Username</label>
                <input type="text" name="faUname" class="form-control"
                       value="{{ old('faUname', $person->faUname ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">2FA Password</label>
                <input type="text" name="faPass" class="form-control"
                       value="{{ old('faPass', $person->faPass ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Backup Code</label>
                <input type="text" name="backupCode" class="form-control"
                       value="{{ old('backupCode', $person->backupCode ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Security Q&A</label>
                <input type="text" name="securityQa" class="form-control"
                       value="{{ old('securityQa', $person->securityQa ?? '') }}">
            </div>
        </div>

    </div>
</div>

<!-- Additional Info -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-light fw-semibold">
        Additional Details
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">CS</label>
                <input type="text" name="cs" class="form-control"
                       value="{{ old('cs', $person->cs ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Purchase Date</label>
                <input type="date" name="purchaseDate" class="form-control"
                       value="{{ old('purchaseDate', $person->purchaseDate ?? '') }}">
            </div>

            <div class="col-12 mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" rows="3" class="form-control">{{ old('description', $person->description ?? '') }}</textarea>
            </div>
        </div>

    </div>
</div>

<!-- Save Button -->
<div class="text-end">
    <button class="btn btn-primary px-4">
        <i class="bi bi-check-circle"></i> Save
    </button>
</div>
