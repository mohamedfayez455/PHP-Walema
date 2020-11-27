<div>
				<div class="resultBar">
					<h2>We found <span class="number"> {{ $number_of_suppliers }} </span> Results for you</h2>

				</div>

				<div class="rows">
					<div class="row">
                        @foreach($suppliers as $supplier)
                    <div class="col-md-4">
                        <div class="card card-product" style="
                            background-color: white;
                            border: 1px;
                            box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
                              height: 370px;
                            color: rgba(0, 0, 0, 0.87);border-radius: 6px;padding-bottom: 10px;margin-bottom: 15px;
                        ">
                            <div class="card-image" style="width: 90%;margin: auto;">
                                <a href="#" style="color: #9c27b0;text-decoration: none;">
                                  <img style="    width: 100%;
                                    height: 100%;
                                    border-radius: 6px;
                                    pointer-events: none;"
                                    class="img" src="{{ asset('/img/default_supplier.jpg') }}">
                                  </a>
                            </div>
                            <div class="table text-center">
                                <h6 class="category text-rose">{{ $supplier->user->email }}</h6>
                                <h5 class="card-caption">
                                  <a href="{{ route('supplier.profile' , $supplier->id) }}">{{ $supplier->name }}</a>
                                </h5>

                                <div class="ftr">

                                    @if($supplier->phone)
                                    <li>
                                        <a href="#">{{ $supplier->phone }}</a>
                                    </li>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
            @endforeach
                      </div>
				<div class="paginationCommon blogPagination categoryPagination">
					<nav aria-label="Page navigation">
							{{ $suppliers->links() }}
					</nav>
				</div>

		</div>