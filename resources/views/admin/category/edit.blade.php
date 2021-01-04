@extends('admin.layouts.app')

@section('content')
    <div class="col s12">
        <div class="container">
            <div class="section">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div class="card animate fadeUp">
                                <div class="card-content">
                                    <h4 class="header mt-0">
                                        Edit Category Sliders
                                        <a class="waves-effect waves-light btn gradient-45deg-purple-deep-orange gradient-shadow right">Details</a>
                                    </h4>
                                    <div class="row">
                                        <div class="col s12">
                                            <h2></h2>
                                        <form method="post" action="{{ route('category-form.update', $category->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                       <div class="form-group">
                                       <label class="col-md-4 text-right">Add Category Name</label>
                                       <div class="col-md-8">
                                       <input type="text" name="category_name" value="{{ $category->category_name }}" class="form-control input-lg" />
                                       </div>
                                       </div>
                                       <div class="form-group">
                                       <label class="col-md-4 text-right">Select Profile Image</label>
                                       <div class="col-md-8">
                                       <input type="file" name="category_image"  />
                                       <input type="hidden" name="hidden_image" value="{{ $category->category_image }}" />
                                       </div>
                                       </div>
                                       <br /><br />
                                       <div class="card-body">
                                        <div class="form-group">
                                        <label for="category_name"></label>
                                        <input type="text" name="category_sorting" value="{{ $category->category_sorting }}"  class="form-control input-lg" />
                                        </div>
                                       <div class="input-field col s12">
                                                <button class="btn waves-effect waves-light right submit" type="submit" name="action">Submit
                                                    <i class="material-icons right">send</i>
                                                </button>
                                        </div>
                                       </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
@endsection
@section('scripts')
    <script src="app-assets/vendors/jquery-validation/jquery.validate.min.js"></script>
<script>
    /*
 * Form Validation
 */
    $(function () {

        $('select[required]').css({
            position: 'absolute',
            display: 'inline',
            height: 0,
            padding: 0,
            border: '1px solid rgba(255,255,255,0)',
            width: 0
        });

        $("#formValidate").validate({
            rules: {
                uname: {
                    required: true,
                    minlength: 5
                },
                cemail: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 5
                },
                cpassword: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
                crole: {
                    required: true,
                },
                curl: {
                    required: true,
                    url: true
                },
                ccomment: {
                    required: true,
                    minlength: 15
                },
                tnc_select: "required",
            },
            //For custom messages
            messages: {
                uname: {
                    required: "Enter a username",
                    minlength: "Enter at least 5 characters"
                },
                curl: "Enter your website",
            },
            errorElement: 'div',
            errorPlacement: function (error, element) {
                var placement = $(element).data('error');
                if (placement) {
                    $(placement).append(error)
                } else {
                    error.insertAfter(element);
                }
            }
        });
    });
</script>
@endsection
