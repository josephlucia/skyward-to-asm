@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3 style="margin: 0 0 15px 5px;">Documentation</h3>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="alert alert-info">
                        Although this app was built to be as intuitive as possible, not all setups are created
                        equal or are straight forward depending on the comfort level of the district technology
                        director or network administrator. So I will try to assist in some common pitfalls to
                        help minimize issues with the configuration of the product.
                    </div>
                    <h4>
                        <strong>Getting Started</strong>
                    </h4>
                    <p>
                        Starting with Skyward build <b>05.16.10.00</b>, the SIS provider included a built-in API to integrate
                        with 3rd party sites to consume read-only data from the database. This is what the application will
                        leverage in order to generate the required Apple School Manager CSV files.
                    </p>
                    <p>
                        The first step in order to use the Skyward API is to make sure the service is enabled and
                        that you are able to create credentials for 3rd party applications. The credentials that are needed
                        consist of 3 specific elements:
                        <ul>
                            <li>Skyward Domain URL</li>
                            <li>Consumer Key</li>
                            <li>Consumer Secret</li>
                        </ul>
                        For the purpose of this application, the Skyward Domain URL will consist of your Skyward URL before
                        the /api and must start with https://. An example would be https://skyward.example.com for a self-hosted
                        customer.
                    </p>
                    <p>
                        For those customers that utilize the Secure Cloud hosted solution (ISCorp), please contact their help
                        support center to have the API enabled by visiting <a href="https://support.iscorp.com/" _target="blank">https://support.iscorp.com/</a>.
                    </p>
                    <p>
                        If you are a self-hosted customer, you can reference the following <a href="https://support.skyward.com/DeptDocs/Corporate/IT%20Services/Public%20Website/Technical%20Information/system/current_requirements/Api%20Server%20Launch%20kit.pdf" _target="blank">Skyward API Launch Kit</a> or open a support
                        ticket using the <a hre="https://support.skyward.com/" _taget="blank">Support Center</a>.
                    </p>
                    <hr>
                    <p>
                        Once you have a working API and valid credentials, you are ready to register your account and enter the values 
                        in the Skyward Sync Configuration window. The status alert will respond with a success or failure message depending
                        on the response by the API. Once the URL and credentials are authenticated, they are stored for future use and the
                        configuration page will show a <i>Validated</i> badge in the lower right hand corner.
                    </p>
                    <hr>
                    <p>
                        During the successful authentication of the credentials for the first time, the application will query the API to populate
                        the locations table. All other API calls to Skyward will require populated school entities. Once populated, you can 
                        click on the Locations tab to view your entities. In some cases certain entities will not contain students or should not
                        be part of the nightly sync process. In this situation, you can set any school to not sync. This will exclude it from the
                        nightly process and prevent the API calls from gathering data from those entities.
                    </p>
                    <hr>
                    <p>
                        In the event of errors or rejections by Apple School Manager regarding the uploaded files, you are provided the ability to run
                        manual sync's on the different tables. This is a great way to fix problems that may be in your Skyward database. Once you correct 
                        certail issues, you can re-run the particular sync you are working on and view the data in the table view.
                    </p>
                    <hr>
                    <h4>
                        <strong>Apple School Manager Files for SFTP</strong>
                    </h4>
                    <p>
                        In order to utilize the nightly SFTP upload supported by Apple School Manager, you need to have 
                        6 perfectly formatted CSV files zipped and uploaded to Apple's servers. More information about the 
                        SFTP process and files can be found in the following support article.
                        <br><br>
                        <a href="https://support.apple.com/en-us/HT207029" target="_blank">https://support.apple.com/en-us/HT207029</a>
                    </p>
                    <hr>
                    <h4>
                        <strong>Nightly Exports</strong>
                    </h4>
                    <p>
                        The full syncronization and export of all the files can be run manually or they can be configure to be automated
                        by utilizing the cron tab on your webserver. The URL of the full sync process for your server is below. 
                        <i><b>The Nightly Sync Status must be set to Enabled in order to run the process manually or in an automated state.</b></i>
                        <div class="alert alert-success">{{ url('/nightly/export') }}</div>
                    </p>
                    <p>
                        Below is an example cron statement to run your sync process each night Monday through Friday at 11:00PM.
                        <br><br>
                        <code>0 23 * * 1-5 wget {{ url('/nightly/export') }} > /dev/null 2>&1</code>
                    </p>
                    <br>
                    <p>
                        Below is an example script that will run the nightly export, zip the files and upload to Apple's servers. You can save this
                        in your /usr/bin or /usr/sbin and call it within the cron. Update the SFTP username and be sure to save your SFTP password to
                        the asm-sftp-password.txt file or another location of your choice. Just update the path as needed.
                        <br>
                        @include('partials.script')
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
