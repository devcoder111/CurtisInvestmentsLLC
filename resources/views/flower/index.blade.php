@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <style>
                            .home-widget .card {
                                height: 100%;
                            }

                            .card .card-img-top {
                                height: 75px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            }
                        </style>

                        <div class="row">
                            <div class="col-md-12">
                                <h3>
                                    Flower completeness - {{ $position }}

                                    <button type="button" class="btn btn-primary btn-sm float-right" disabled>
                                        + Invite to Flower
                                    </button>

                                    @if($requiresPayment)
                                    <button type="button" class="btn btn-danger btn-sm float-right mr-2">
                                        Pay Blessing
                                    </button>
                                    @endif
                                </h3>

                                <div class="progress mb-4">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="100%" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                        100%
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Current cycle
                                        <span class="">1</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Current week
                                        <span class="">1</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Users in flower
                                        <span class="badge badge-primary badge-pill">15/15</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Current cycle payment
                                        <span class="">100$</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Current cycle blessing
                                        <span class="">800$</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Weeks until blessing
                                        <span class="badge badge-primary badge-pill">4</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div id="myVisualTree" style="border: 1px solid black; background:#1F4963; width: 100%; height: 300px"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let myVisualTree;
        let data = JSON.parse('{!! $tree !!}');
        data = data[0];

        function init() {
            let $go = go.GraphObject.make;

            // Now we can initialize a Diagram that looks at the visual tree that constitutes the Diagram above.
            myVisualTree =
                $go(go.Diagram, "myVisualTree",
                    {
                        initialContentAlignment: go.Spot.Left,
                        initialAutoScale: go.Diagram.Uniform,
                        isReadOnly: true,  // do not allow users to modify or select in this view
                        allowSelect: false,
                        layout: $go(go.TreeLayout, { nodeSpacing: 5 })  // automatically laid out as a tree
                    });

            myVisualTree.nodeTemplate =
                $go(go.Node, "Auto",
                    $go(go.Shape, { fill: "darkkhaki", stroke: null }),  // assume a dark background
                    $go(go.TextBlock,
                        {
                            font: "bold 13px Helvetica, bold Arial, sans-serif",
                            stroke: "black",
                            margin: 3
                        },
                        // bind the text to the Diagram/Layer/Part/GraphObject converted to a string
                        new go.Binding("text", "", function(x) {
                            // if the node represents a link, be sure to include the "to/from" data for that link
                            return x.user.first_name + ' ' + x.user.last_name;
                        }))
                );

            myVisualTree.linkTemplate =
                $go(go.Link,
                    $go(go.Shape, { stroke: "darkkhaki", strokeWidth: 2 })
                );

            drawVisualTree();
        }

        function drawVisualTree() {
            let visualNodeDataArray = [];

            // recursively walk the visual tree, collecting objects as we go
            function traverseVisualTree(obj, parent) {
                obj.vtkey = visualNodeDataArray.length;
                visualNodeDataArray.push(obj);
                if (parent) {
                    obj.parentKey = parent.vtkey;
                }
                obj.children.forEach((child) => {
                    traverseVisualTree(child, obj)
                });
            }

            traverseVisualTree(data, null);

            myVisualTree.model =
                go.GraphObject.make(go.TreeModel,
                    {
                        nodeKeyProperty: "vtkey",
                        nodeParentKeyProperty: "parentKey",
                        nodeDataArray: visualNodeDataArray
                    });
        }

        init();

    </script>
@endpush

