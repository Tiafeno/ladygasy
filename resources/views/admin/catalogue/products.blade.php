@extends('layouts.admin')
@section('title', "Tous les produits")
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="javascript: void(0);">Tableau de bord</a></li>
@endsection
@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row mb-2">
            <div class="col-sm-5">
              <a href="{{route('created.admin.product')}}" class="btn btn-danger mb-2"><i class="mdi mdi-plus-circle me-2"></i>
                Ajouter une article</a>
            </div>
            <div class="col-sm-7">
              <div class="text-sm-end">
                <button type="button" class="btn btn-success mb-2 me-1"><i class="mdi mdi-cog-outline"></i></button>
              </div>
            </div><!-- end col-->
          </div>

          <div class="table-responsive-md">
            <table class="table table-centered table-hover " id="products-datatable">
              <thead class="table-light">
                <tr>
                  <th class="all" style="width: 20px;">
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="customCheck1">
                      <label class="form-check-label" for="customCheck1">&nbsp;</label>
                    </div>
                  </th>
                  <th class="all">Product</th>
                  <th>Category</th>
                  <th>Added Date</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Status</th>
                  <th style="width: 85px;">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="customCheck2">
                      <label class="form-check-label" for="customCheck2">&nbsp;</label>
                    </div>
                  </td>
                  <td>
                    <img src="assets/images/products/product-1.jpg" alt="contact-img" title="contact-img"
                         class="rounded me-3" height="48"/>
                    <p class="m-0 d-inline-block align-middle font-16">
                      <a href="apps-ecommerce-products-details.html" class="text-body">Amazing Modern Chair</a>
                    </p>
                  </td>
                  <td>
                    Aeron Chairs
                  </td>
                  <td>
                    09/12/2018
                  </td>
                  <td>
                    $148.66
                  </td>

                  <td>
                    254
                  </td>
                  <td>
                    <span class="badge bg-success">Active</span>
                  </td>

                  <td class="table-action">
                    <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                    <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                  </td>
                </tr>

                <tr>
                  <td>
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="customCheck3">
                      <label class="form-check-label" for="customCheck3">&nbsp;</label>
                    </div>
                  </td>
                  <td>
                    <img src="assets/images/products/product-4.jpg" alt="contact-img" title="contact-img"
                         class="rounded me-3" height="48"/>
                    <p class="m-0 d-inline-block align-middle font-16">
                      <a href="apps-ecommerce-products-details.html" class="text-body">Biblio Plastic Armchair</a>
                      <br/>
                      <span class="text-warning mdi mdi-star"></span>
                      <span class="text-warning mdi mdi-star"></span>
                      <span class="text-warning mdi mdi-star"></span>
                      <span class="text-warning mdi mdi-star"></span>
                      <span class="text-warning mdi mdi-star-half"></span>
                    </p>
                  </td>
                  <td>
                    Wooden Chairs
                  </td>
                  <td>
                    09/08/2018
                  </td>
                  <td>
                    $8.99
                  </td>

                  <td>
                    1,874
                  </td>
                  <td>
                    <span class="badge bg-success">Active</span>
                  </td>
                  <td class="table-action">
                    <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                    <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div> <!-- end card-body-->
      </div> <!-- end card-->
    </div> <!-- end col -->
  </div>
  <!-- end row -->
@endsection
