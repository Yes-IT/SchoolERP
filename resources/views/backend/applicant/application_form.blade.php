@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')
     

            <!-- Dashboard Body Begin -->

                <div class="dashboard-body dspr-body-outer">
                  

                    <div class="ds-breadcrumb">
                        <h1>Application Form</h1>
                        <ul>
                            <li><a href="../dashboard.html">Dashboard</a> /</li>
                            <li>Application Form</li>
                        </ul>
                    </div>
                    <div class="ds-pr-body">
                        <div class="ds-cmn-table-wrp">
                            
                            <div class="request-leave-form spradmin">
                                
                                <form>
                                    <div class="cmn-form-row">
                                        <h3>Category Name</h3>
                                        <div class="input-grp has-edit-btn">
                                            <input name="Purim" type="text" disabled placeholder="Purim">
                                            <button type="button"><img src="{{ global_asset('backend/assets/images/edit-icon-primary.svg')}}" alt="Icon"></button>
                                        </div>
                                    </div>

                                    <div class="cmn-form-row cmn-box-style">
                                        <h3>Add Fields</h3>

                                        <div class="multi-input-grp grp-4">
                                            <div class="input-grp">
                                                <select>
                                                    <option value="option-1">Standard Fields</option>
                                                    <option value="option-1">Option 1</option>
                                                </select>
                                            </div>
                                            <div class="input-grp">
                                                <select>
                                                    <option value="option-1">Standard Fields</option>
                                                    <option value="option-1">Option 1</option>
                                                </select>
                                            </div>
                                            <div class="input-grp">
                                                <select>
                                                    <option value="option-1">Standard Fields</option>
                                                    <option value="option-1">Option 1</option>
                                                </select>
                                            </div>
                                            <div class="input-grp">
                                                <select>
                                                    <option value="option-1">Standard Fields</option>
                                                    <option value="option-1">Option 1</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="cmn-box-style multi-input-grp grp-5 m-0 add-fields" aria-label="Available fields">
                                            <div class="input-grp">
                                              <div class="field-card">
                                                <div class="field-cd-icon"><img src="{{global_asset('backend/assets/images/field-icon-1.svg')}}" alt="Icon"></div>
                                                <div class="field-label">Section</div>
                                              </div>
                                            </div>
                                            <div class="input-grp">
                                              <div class="field-card">
                                                <div class="field-cd-icon"><img src="{{global_asset('backend/assets/images/field-icon-1.svg')}}" alt="Icon"></div>
                                                <div class="field-label">Section</div>
                                              </div>
                                            </div>
                                            <div class="input-grp">
                                              <div class="field-card">
                                                <div class="field-cd-icon"><img src="{{global_asset('backend/assets/images/field-icon-2.svg')}}" alt="Icon"></div>
                                                <div class="field-label">Section</div>
                                              </div>
                                            </div>
                                            <div class="input-grp">
                                              <div class="field-card">
                                                <div class="field-cd-icon"><img src="{{global_asset('backend/assets/images/field-icon-3.svg')}}" alt="Icon"></div>
                                                <div class="field-label">Section</div>
                                              </div>
                                            </div>
                                            <div class="input-grp">
                                              <div class="field-card">
                                                <div class="field-cd-icon"><img src="{{global_asset('backend/assets/images/field-icon-4.svg')}}" alt="Icon"></div>
                                                <div class="field-label">Section</div>
                                              </div>
                                            </div>
                                            <div class="input-grp">
                                              <div class="field-card">
                                                <div class="field-cd-icon"><img src="{{global_asset('backend/assets/images/field-icon-5.svg')}}" alt="Icon"></div>
                                                <div class="field-label">Section</div>
                                              </div>
                                            </div>
                                            <div class="input-grp">
                                              <div class="field-card">
                                                <div class="field-cd-icon"><img src="{{global_asset('backend/assets/images/field-icon-6.svg')}}" alt="Icon"></div>
                                                <div class="field-label">Section</div>
                                              </div>
                                            </div>
                                            <div class="input-grp">
                                              <div class="field-card">
                                                <div class="field-cd-icon"><img src="{{global_asset('backend/assets/images/field-icon-7.svg')}}" alt="Icon"></div>
                                                <div class="field-label">Section</div>
                                              </div>
                                            </div>
                                            <div class="input-grp">
                                              <div class="field-card">
                                                <div class="field-cd-icon"><img src="{{global_asset('backend/assets/images/field-icon-8.svg')}}" alt="Icon"></div>
                                                <div class="field-label">Section</div>
                                              </div>
                                            </div>
                                            <div class="input-grp">
                                              <div class="field-card">
                                                <div class="field-cd-icon"><img src="{{global_asset('backend/assets/images/field-icon-9.svg')}}" alt="Icon"></div>
                                                <div class="field-label">Section</div>
                                              </div>
                                            </div>
                                        </div>
                                          
                                    </div>

                                    <div class="cmn-form-row">
                                        <div class="cmn-form-row-head">
                                            <div class="cmn-frh-left">
                                                <h4>School year starts in</h4>
                                                <p>(Used for calculating age in September)</p>
                                            </div>
                                            <div class="cmn-frh-actions">
                                                <div class="action-toolbar" role="toolbar" aria-label="Field actions">
                                                    <button class="action-btn" aria-label="Drag" title="Drag" data-action="drag">
                                                        <img src="{{global_asset('backend/assets/images/action-toolbar-icon-1.svg')}}" alt="Icon">
                                                    </button>
                                                    <button class="action-btn" aria-label="Duplicate" title="Duplicate" data-action="duplicate">
                                                        <img src="{{global_asset('backend/assets/images/action-toolbar-icon-2.svg')}}" alt="Icon">
                                                    </button>
                                                    <button class="action-btn" aria-label="Edit" title="Edit" data-action="edit">
                                                        <img src="{{global_asset('backend/assets/images/action-toolbar-icon-3.svg')}}" alt="Icon">
                                                    </button>
                                                    <button class="action-btn danger" aria-label="Delete" title="Delete" data-action="delete">
                                                        <img src="{{global_asset('backend/assets/images/action-toolbar-icon-4.svg')}}" alt="Icon">
                                                    </button>
                                                </div>
                                            </div>
                                              
                                        </div>
                                        <div class="input-grp">
                                            <input name="Purim" type="text">
                                        </div>
                                    </div>

                                    <div class="cmn-form-row">
                                        <div class="cmn-form-row-head brdr">
                                            <div class="cmn-frh-actions">
                                                <div class="action-toolbar" role="toolbar" aria-label="Field actions">
                                                    <button class="action-btn" aria-label="Drag" title="Drag" data-action="drag">
                                                        <img src="{{global_asset('backend/assets/images/action-toolbar-icon-1.svg')}}" alt="Icon">
                                                    </button>
                                                
                                                    <button class="action-btn" aria-label="Duplicate" title="Duplicate" data-action="duplicate">
                                                        <img src="{{global_asset('backend/assets/images/action-toolbar-icon-2.svg')}}" alt="Icon">
                                                    </button>
                                                
                                                    <button class="action-btn" aria-label="Edit" title="Edit" data-action="edit">
                                                        <img src="{{global_asset('backend/assets/images/action-toolbar-icon-3.svg')}}" alt="Icon">
                                                    </button>
                                                
                                                    <button class="action-btn danger" aria-label="Delete" title="Delete" data-action="delete">
                                                        <img src="{{global_asset('backend/assets/images/action-toolbar-icon-4.svg')}}" alt="Icon">
                                                    </button>
                                                
                                                    <button class="action-btn" aria-label="Collapse" title="Collapse" data-action="collapse" aria-pressed="false">
                                                        <i class="fa-solid fa-chevron-down"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="cmn-form-inr-row">
                                            <div class="cmn-form-row-head">
                                                <div class="cmn-frh-actions">
                                                    <div class="action-toolbar" role="toolbar" aria-label="Field actions">
                                                        <button class="action-btn" aria-label="Drag" title="Drag" data-action="drag">
                                                            <img src="{{global_asset('backend/assets/images/action-toolbar-icon-1.svg')}}" alt="Icon">
                                                        </button>
                                                        <button class="action-btn" aria-label="Duplicate" title="Duplicate" data-action="duplicate">
                                                            <img src="{{global_asset('backend/assets/images/action-toolbar-icon-2.svg')}}" alt="Icon">
                                                        </button>
                                                        <button class="action-btn" aria-label="Edit" title="Edit" data-action="edit">
                                                            <img src="{{global_asset('backend/assets/images/action-toolbar-icon-3.svg')}}" alt="Icon">
                                                        </button>
                                                        <button class="action-btn danger" aria-label="Delete" title="Delete" data-action="delete">
                                                            <img src="{{global_asset('backend/assets/images/action-toolbar-icon-4.svg')}}" alt="Icon">
                                                        </button>
                                                    </div>
                                                </div>
                                                  
                                            </div>
                                            <div class="input-grp">
                                                <label>Title</label>
                                                <input type="text">
                                            </div>
                                            <div class="input-grp">
                                                <label>First Name <span>*</span></label>
                                                <input type="text">
                                            </div>
                                            <div class="input-grp">
                                                <label>Last Name <span>*</span></label>
                                                <input type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="cmn-form-row">
                                        <div class="cmn-form-row-head">
                                            <div class="cmn-frh-actions">
                                                <div class="action-toolbar" role="toolbar" aria-label="Field actions">
                                                    <button class="action-btn" aria-label="Drag" title="Drag" data-action="drag">
                                                        <img src="{{global_asset('backend/assets/images/action-toolbar-icon-1.svg')}}" alt="Icon">
                                                    </button>
                                                
                                                    <button class="action-btn" aria-label="Duplicate" title="Duplicate" data-action="duplicate">
                                                        <img src="{{global_asset('backend/assets/images/action-toolbar-icon-2.svg')}}" alt="Icon">
                                                    </button>
                                                
                                                    <button class="action-btn" aria-label="Edit" title="Edit" data-action="edit">
                                                        <img src="{{global_asset('backend/assets/images/action-toolbar-icon-3.svg')}}" alt="Icon">
                                                    </button>
                                                
                                                    <button class="action-btn danger" aria-label="Delete" title="Delete" data-action="delete">
                                                        <img src="{{global_asset('backend/assets/images/action-toolbar-icon-4.svg')}}" alt="Icon">
                                                    </button>
                                                
                                                    <button class="action-btn" aria-label="Collapse" title="Collapse" data-action="collapse" aria-pressed="false">
                                                        <i class="fa-solid fa-chevron-down"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="cmn-box-style">
                                            <div class="input-grp">
                                                <label>Title</label>
                                                <input type="text">
                                            </div>
                                            <div class="input-grp">
                                                <label>First Name <span>*</span></label>
                                                <input type="text">
                                            </div>
                                            <div class="input-grp">
                                                <label>Last Name <span>*</span></label>
                                                <input type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="cmn-form-row">
                                        <div class="cmn-form-row-head">
                                            <div class="cmn-frh-actions">
                                                <div class="action-toolbar" role="toolbar" aria-label="Field actions">
                                                    <button class="action-btn" aria-label="Drag" title="Drag" data-action="drag">
                                                        <img src="{{global_asset('backend/assets/images/action-toolbar-icon-1.svg')}}" alt="Icon">
                                                    </button>
                                                
                                                    <button class="action-btn" aria-label="Duplicate" title="Duplicate" data-action="duplicate">
                                                        <img src="{{global_asset('backend/assets/images/action-toolbar-icon-2.svg')}}" alt="Icon">
                                                    </button>
                                                
                                                    <button class="action-btn" aria-label="Edit" title="Edit" data-action="edit">
                                                        <img src="{{global_asset('backend/assets/images/action-toolbar-icon-3.svg')}}" alt="Icon">
                                                    </button>
                                                
                                                    <button class="action-btn danger" aria-label="Delete" title="Delete" data-action="delete">
                                                        <img src="{{global_asset('backend/assets/images/action-toolbar-icon-4.svg')}}" alt="Icon">
                                                    </button>
                                                
                                                    <button class="action-btn" aria-label="Collapse" title="Collapse" data-action="collapse" aria-pressed="false">
                                                        <i class="fa-solid fa-chevron-down"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="cmn-box-style">
                                            <div class="cmn-form-row-head">
                                                <div class="cmn-frh-left">
                                                    <h4>2 family</h4>
                                                </div>
                                                <div class="cmn-frh-actions">
                                                    <div class="action-toolbar" role="toolbar" aria-label="Field actions">
                                                        <button class="action-btn" aria-label="Drag" title="Drag" data-action="drag">
                                                            <img src="{{global_asset('backend/assets/images/action-toolbar-icon-1.svg')}}" alt="Icon">
                                                        </button>
                                                        <button class="action-btn" aria-label="Duplicate" title="Duplicate" data-action="duplicate">
                                                            <img src="{{global_asset('backend/assets/images/action-toolbar-icon-2.svg')}}" alt="Icon">
                                                        </button>
                                                        <button class="action-btn" aria-label="Edit" title="Edit" data-action="edit">
                                                            <img src="{{global_asset('backend/assets/images/action-toolbar-icon-3.svg')}}" alt="Icon">
                                                        </button>
                                                        <button class="action-btn danger" aria-label="Delete" title="Delete" data-action="delete">
                                                            <img src="{{global_asset('backend/assets/images/action-toolbar-icon-4.svg')}}" alt="Icon">
                                                        </button>
                                                    </div>
                                                </div>
                                                  
                                            </div>
                                            <div class="mcq-wrp">
                                                <div class="input-grp question text-red">
                                                    <label>Question</label>
                                                    <input type="text" placeholder="Parent's marital status *" disabled>
                                                </div>

                                                <div class="mcq-options">
                                                    <div class="input-grp">
                                                        <label>
                                                            <input type="radio" name="option">
                                                            <span>Married</span>
                                                        </label>
                                                    </div>
                                                    <div class="input-grp">
                                                        <label>
                                                            <input type="radio" name="option">
                                                            <span>Married</span>
                                                        </label>
                                                    </div>
                                                    <div class="input-grp">
                                                        <label>
                                                            <input type="radio" name="option">
                                                            <span>Married</span>
                                                        </label>
                                                    </div>
                                                    <div class="input-grp">
                                                        <label>
                                                            <input type="radio" name="option">
                                                            <span>Married</span>
                                                        </label>
                                                    </div>
                                                    <div class="input-grp">
                                                        <label>
                                                            <input type="radio" name="option">
                                                            <span>Married</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-submission btn-sm align-right">
                                        <input type="submit" value="Cancel">
                                        <input type="submit" value="Publish">
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            <!-- End Of Dashboard Body -->

      



@endsection