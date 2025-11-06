@extends('applicant.partials.app')

@section('content')
    <div class="dashboard-body dspr-body-outer">
        @include('applicant.partials.header')

        <div class="ds-breadcrumb">
            <h1>Application to <span class="txt-primary">Me'ohr Bais Yaakov</span> Seminary 5786</h1>
            <ul>
                <li>Welcome to our online application. Applications must be submitted by December 19, 2024.</li>
            </ul>

        </div>
        <div class="ds-pr-body">

            <div class="ds-cmn-table-wrp">
                <div class="sec-head">
                    <h2 class="txt-primary">The application process has 3 steps:</h2>
                </div>
                <div class="dsbdycmncd-body">
                    <div class="timeline-steps">
                        <div class="timeline-item">
                            <div class="timeline-left">
                                <div class="timeline-icon" aria-hidden="true">
                                    <img src="{{ asset('student\images\timestamp-icon-1.svg') }}" alt="">
                                </div>
                            </div>
                            <div class="timeline-right">
                                <h3>Let us get to know you</h3>
                                <p>Download the following pages to be filled out by hand and scanned. (Print extra copies of
                                    the second page
                                    if needed.)</p>
                                <p><strong>This must be completed in black pen only. If it cannot be read, your application
                                        will not be accepted.</strong> Please double-check your scans to ensure they are
                                    clear! Pictures are not acceptable. Files should be scanned using a flatbed scanner or a
                                    scanning app.</p>
                                <a class="cmn-btn btn-sm" href="#download" onclick="downloadFile()">Download Here</a>



                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-left">
                                <div class="timeline-icon" aria-hidden="true">
                                    <img src="{{ asset('student/images/timestamp-icon-2.svg') }}" alt="">
                                </div>
                            </div>
                            <div class="timeline-right">
                                <h3>Prepare uploads</h3>
                                <ul class="timeline-list">
                                    <li>Two letters of recommendation (black pen or typed)</li>
                                    <li>High school transcripts</li>
                                    <li>Attendance records</li>
                                    <li>Photo of applicant</li>
                                </ul>
                                <p class="muted">If your school does not give these to students, you will have the option
                                    to have your
                                    school upload them.</p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-left">
                                <div class="timeline-icon" aria-hidden="true">
                                    <img src="{{ asset('student/images/timestamp-icon-3.svg') }}" alt="">
                                </div>
                            </div>
                            <div class="timeline-right">
                                <h3>Fill out application</h3>
                                <p>With steps 1 & 2 complete, you’re now ready to start filling in the application form.</p>
                                <p class="muted">When your application is submitted successfully, you will receive a
                                    confirmation email.
                                    Please check spam/junk mail if you don't see it.</p>
                                <a class="cmn-btn btn-sm" href="{{ route('applicant.application') }}">Start application</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('script')
    <script>
        function downloadFile() {
            const link = document.createElement('a');
            link.href = '{{ asset('student/images/hh.pdf') }}';
            link.download = 'student_file.pdf';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
@endpush
