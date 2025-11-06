@extends('applicant.partials.app')

@section('content')
    <style>
        .dspr-body-outer {
            transition: opacity 0.4s ease;
        }

        .dspr-body-outer[style*="display: none"] {
            opacity: 0;
        }

        .dspr-body-outer[style*="display: block"] {
            opacity: 1;
        }

        .signature-area {
            border: 2px solid #ccc;
            border-radius: 6px;
            background: #fff;
            width: 100%;
            max-width: 400px;
            height: 150px;
            position: relative;
        }

        /* Canvas fills the box */
        .signature-area canvas {
            width: 100%;
            height: 100%;
        }

        /* Add "Clear" button using ::after */
        .signature-area::after {
            content: "Clear";
            position: absolute;
            bottom: 6px;
            right: 10px;
            /* background: #f44336; */
            color: #fff;
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 4px;
            cursor: pointer;
            user-select: none;
            transition: background 0.3s;
        }

        .signature-area::after:hover {
            background-image: ../../public/images/Vector.png;
        }
    </style>
    <div class="dashboard-body dspr-body-outer" id="agreementPart1">
        @include('applicant.partials.header')
        <div class="ds-breadcrumb text-light">
            <h1>Student Agreement</h1>
        </div>
        <div class="ds-pr-body">
            <div class="ds-cmn-table-wrp">
                <section class="agreement-page">
                    <div class="agreement-wrap">
                        <div class="agreement-wrap">
                            <div class="agreement-header">
                                <div class="steps">
                                    <div class="step-bubble">1 <i class="fa-solid fa-check"></i></div>
                                    <div class="step-line"></div>
                                    <div class="step-bubble inactive">2</div>
                                </div>
                            </div>

                            <div class="agreement-content">
                                <ul class="policy-list">
                                    <li>All clothing must be in accordance with Hilchos Tznius, not tight or clinging.</li>

                                    <li><strong>School uniform:</strong> must be worn all day on school days:
                                        <ul>
                                            <li><strong>Shirts:</strong>
                                                <ul>
                                                    <li>Button-down blouses with a collar that covers the neckline on all
                                                        sides.
                                                    </li>
                                                    <li>Turtlenecks are not considered collared blouses.</li>
                                                    <li>Sweaters or refined solid colors may be worn over the blouse if they
                                                        are
                                                        not tight
                                                        and have no pictures or words on them.</li>
                                                    <li>Activewear shirts may not be worn on top of blouses.</li>
                                                    <li>No sweatshirts may be worn including hoodies, zip ups, school and
                                                        camp
                                                        sweatshirts.
                                                    </li>
                                                    <li>Polo shirts may only be worn for Tiyulim.</li>
                                                </ul>
                                            </li>
                                            <li><strong>Skirts:</strong> Black or navy box-pleated long uniform skirts.</li>
                                        </ul>
                                    </li>

                                    <li><strong>Shabbos and vacation days:</strong>
                                        <ul>
                                            <li><strong>Shirts:</strong> Must cover the collar and elbows at all times. No
                                                words
                                                or images
                                                are allowed on shirts.</li>
                                            <li><strong>Skirts:</strong> Skirts must cover knees at all times including:
                                                walking, running,
                                                sitting and standing. No shiny or tight skirts may be worn.</li>
                                        </ul>
                                    </li>

                                    <li><strong>Knee-high socks, tights or stockings</strong> must be worn at all times
                                        regardless of skirt
                                        length.</li>
                                    <li>Color must be of solid color in black, navy, blue or white. No patterns are
                                        permitted.
                                    </li>
                                    <li>No ankle and/or crew socks. Please do not bring them with you.</li>
                                    <li>Leggings may be worn for tiyulim or exercise only with the same color sock to cover
                                        the
                                        leg
                                        completely.</li>
                                    <li>Activewear is only for exercise and cannot be tight.</li>
                                    <li>No crop tops may be worn at any time.</li>

                                    <li><strong>Proper shoes</strong> must be worn at all times.
                                        <ul>
                                            <li>Slippers and slides including Uggs are not considered shoes and are not to
                                                be
                                                worn to class
                                                or out of school; they are for the dorm only.</li>
                                            <li>No high-top sneakers may be worn.</li>
                                            <li>Sneakers should be refined and not activewear.</li>
                                        </ul>
                                    </li>

                                    <li>Hair longer than shoulder length must be gathered.</li>
                                    <li>Nail polish may not be worn.</li>
                                    <li>Denim and Jean skirts may not be worn at any time.</li>

                                    <li>In general, your appearance should be neat and refined at all times with clothing
                                        that
                                        affirms your
                                        self-dignity and that adheres to the standards of Eretz Yisroel.</li>
                                </ul>

                                <p class="ack">I have read and understood the dress code outlined above and I feel that I
                                    can
                                    keep these
                                    standards.</p>

                                <label class="field-label">Signature <span class="red-txt">(Required)</span></label>
                                <div class="signature-fields-wrp">
                                    <div class="signature-area" id="signatureArea">
                                        <canvas id="signatureCanvas" width="600" height="200"></canvas>
                                    </div>
                                </div>



                                <div class="actions-row">
                                    <button class="cmn-btn btn-sm" id="nextBtn">Next</button>
                                    <button class="cmn-btn btn-sm" id="saveBtn">Save and Continue Later</button>
                                </div>

                                <div id="message" class="form-msg" aria-live="polite"></div>
                            </div>
                        </div>
                </section>

            </div>
        </div>
    </div>
    <div class="dashboard-body dspr-body-outer" id="agreementPart2" style="display: none;">
        @include('applicant.partials.header')
        <div class="ds-breadcrumb text-light">
            <h1>Student Agreement</h1>
        </div>
        <div class="ds-pr-body">
            <div class="ds-cmn-table-wrp">
                <section class="agreement-page">
                    <div class="agreement-wrap">
                        <div class="agreement-wrap">
                            <div class="agreement-header">
                                <div class="steps">
                                    <div class="step-bubble inactive">1</div>
                                    <div class="step-line"></div>
                                    <div class="step-bubble">2 <i class="fa-solid fa-check"></i></div>
                                </div>
                            </div>
                            <div class="agreement-content">
                                <h1>Part 2: Behavior</h1>
                                <ul class="policy-list">
                                    <li>You have chosen to join a dormitory that is a place of kedusha, it is therefore
                                        understood that outside influences in the form of inappropriate literature, music or
                                        iPod content have no place.</li>

                                    <li>No Smart Phones, Androids, iPhones, iPads iWatches, iPods or any other internet- or
                                        video-capable devices are allowed in the dormitory at any time. If brought, they
                                        will be confiscated and not returned. The school will have the right to take further
                                        action as well.
                                    </li>

                                    <li>We invited you to join Me’ohr because you are a girl who will act with derech eretz
                                        to our teachers and one another, while complying with the schedules, classes and
                                        extracurricular activities of the Seminary. You therefore agree to:
                                        <ul>
                                            <li>Attend all classes and school activities.</li>
                                            <li>Comply with all school regulations regarding Shabbos and Yom Tov plans.</li>
                                            <li>Avoid all places which the school deems inappropriate. These areas will be
                                                specified in school. </li>
                                            <li>Strictly follow all security-related announcements and instructions.</li>
                                        </ul>
                                    </li>


                                    <li>In addition, you understand that:
                                        <ul>
                                            <li>Hotels and empty apartments will only be visited in the company of parents
                                                or with prior administrative consent.</li>
                                            <li>Travel during the school year is limited to weddings (10 days) and bar
                                                mitzvahs (7 days) of immediate family members.</li>
                                            <li>Spending Pesach in Eretz Yisroel will be in accordance to school polices.
                                            </li>
                                            <li>Pesach out of Eretz Yisroel may be spent with your parents only.</li>
                                        </ul>
                                    </li>


                                </ul>

                                <p class="ack">I have read and understood the behavior outlined above and I feel that I
                                    can keep these standards with respect to myself and Me’ohr Bais Yaakov.</p>


                                <div class="signature-fields-wrp">
                                    <label>Student's Signature <span class="red-txt">(Required)</span></label>
                                    <label>Mother's Signature <span class="red-txt">(Required)</span></label>
                                    <label>Fathers's Signature <span class="red-txt">(Required)</span></label>
                                </div>
                                <div class="signature-fields-wrp">
                                    <div class="signature-area" id="signatureArea2">
                                        <canvas id="signatureCanvas2" width="600" height="200"></canvas>
                                    </div>

                                    <div class="signature-area" id="signatureArea3">
                                        <canvas id="signatureCanvas3" width="600" height="200"></canvas>
                                    </div>

                                    <div class="signature-area" id="signatureArea4">
                                        <canvas id="signatureCanvas4" width="600" height="200"></canvas>
                                    </div>
                                </div>

                                <div class="actions-row">

                                    <button class="cmn-btn btn-sm" id="prevBtn2">Previous</button>
                                    <button class="cmn-btn btn-sm" id="Submit">Submit</button>
                                    <button class="cmn-btn btn-sm" id="saveBtn2">Save and Continue Later</button>

                                </div>
                                <div id="message" class="form-msg" aria-live="polite"></div>
                            </div>
                        </div>
                </section>

            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            const part1 = $('#agreementPart1');
            const part2 = $('#agreementPart2');
            $('#nextBtn').on('click', function() {
                part1.hide();
                part2.show();
                $('html, body').animate({
                    scrollTop: 0
                }, 'smooth');
            });

            // Go back to Part 1
            $('#prevBtn2').on('click', function() {
                part2.hide();
                part1.show();
                $('html, body').animate({
                    scrollTop: 0
                }, 'smooth');
            });
        });
    </script>
    <script>
        $(function() {
            // Function to initialize a signature pad for each canvas + area
            function initSignaturePad(canvasId, areaId) {
                const canvas = document.getElementById(canvasId);
                const signaturePad = new SignaturePad(canvas, {
                    backgroundColor: '#fff',
                    penColor: '#000',
                });

                // Resize for HiDPI displays
                function resizeCanvas() {
                    const ratio = Math.max(window.devicePixelRatio || 1, 1);
                    canvas.width = canvas.offsetWidth * ratio;
                    canvas.height = canvas.offsetHeight * ratio;
                    canvas.getContext('2d').scale(ratio, ratio);
                    signaturePad.clear();
                }

                resizeCanvas();
                window.addEventListener('resize', resizeCanvas);

                // Handle ::after Clear click area
                $('#' + areaId).on('click', function(e) {
                    const area = this.getBoundingClientRect();

                    const clearWidth = 60; // Width of the "Clear" text/button area
                    const clearHeight = 30; // Height of the clickable area
                    const padding = 10; // Distance from edges

                    const insideClearBtn =
                        e.clientX >= area.right - clearWidth - padding &&
                        e.clientY >= area.bottom - clearHeight - padding;

                    if (insideClearBtn) {
                        signaturePad.clear();
                    }
                });
            }

            // Initialize all signature pads
            initSignaturePad('signatureCanvas', 'signatureArea');
            initSignaturePad('signatureCanvas2', 'signatureArea2');
            initSignaturePad('signatureCanvas3', 'signatureArea3');
            initSignaturePad('signatureCanvas4', 'signatureArea4');
        });
    </script>
@endpush
