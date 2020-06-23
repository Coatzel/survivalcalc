<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>

<style>
	.twbs .filled
	{
		opacity: 0.5;
	}
	.twbs .status
	{
		text-align: center;
	    background: #e87171;
	    font-size: 14px;
	    padding: 10px;
	    margin-bottom: 20px;
	    font-weight: bold;
	    color: #fff;
	}
</style>
<script>

	var app = angular.module("ItemCalculator", []);
	app.controller("MainController", function($scope,$http)
	{

		$scope.last_message = "";
		$scope.calculator = {
			"messages":
			{
				"rank_team":"Great Job. Wait for your instructor to provide you a Password to Reveal the Answers",
				"rank_individual":"Good. Now Fill up the Second Columns",
				"password_revealed":"Now check your score",
				"default":"Fill in the Column 'Rank Individually' First"
			},
			"expert_rank_password":"sid",
			"reveal_expert_rank":false,
			"items":
			{
				"sleeping_bag":
				{
					"name":"sleeping_bag",
					"label":"Sleeping Bag Per Person",
					"rank_individual":0,
					"rank_team":0,
					"rank_expert":7
				},
				"snow_shoes":
				{
					"name":"snow_shoes",
					"label":"Snow Shoes",
					"rank_individual":0,
					"rank_team":0,
					"rank_expert":8
				},
				"maple_syrup":
				{
					"name":"maple_syrup",
					"label":"Maple Syrup",
					"rank_individual":0,
					"rank_team":0,
					"rank_expert":9
				},
				"water_purification_tablets":
				{
					"name":"water_purification_tablets",
					"label":"Water Purification Tablets",
					"rank_individual":0,
					"rank_team":0,
					"rank_expert":10
				},
				"hand_axe":
				{
					"name":"hand_axe",
					"label":"Hand Axe",
					"rank_individual":0,
					"rank_team":0,
					"rank_expert":11
				},
				"nylon_rope":
				{
					"name":"nylon_rope",
					"label":"Nylon Rope",
					"rank_individual":0,
					"rank_team":0,
					"rank_expert":1
				},
				"rum":
				{
					"name":"rum",
					"label":"Rum",
					"rank_individual":0,
					"rank_team":0,
					"rank_expert":2
				},
				"inner_tube":
				{
					"name":"inner_tube",
					"label":"Inner Tube",
					"rank_individual":0,
					"rank_team":0,
					"rank_expert":12
				},
				"alarm_clock":
				{
					"name":"alarm_clock",
					"label":"Alarm Clock",
					"rank_individual":0,
					"rank_team":0,
					"rank_expert":13
				},
				"heavy_duty_canvas":
				{
					"name":"heavy_duty_canvas",
					"label":"Heavy Duty Canvas",
					"rank_individual":0,
					"rank_team":0,
					"rank_expert":14
				},
				"matches":
				{
					"name":"matches",
					"label":"Matches",
					"rank_individual":0,
					"rank_team":0,
					"rank_expert":3
				},
				"compass":
				{
					"name":"compass",
					"label":"Compass",
					"rank_individual":0,
					"rank_team":0,
					"rank_expert":4
				},
				"flashlight":
				{
					"name":"flashlight",
					"label":"Flashlight",
					"rank_individual":0,
					"rank_team":0,
					"rank_expert":5
				},
				"book":
				{
					"name":"book",
					"label":"Book",
					"rank_individual":0,
					"rank_team":0,
					"rank_expert":15
				},
				"shaving_kit":
				{
					"name":"shaving_kit",
					"label":"Shaving Kit",
					"rank_individual":0,
					"rank_team":0,
					"rank_expert":6
				}
			}
		};

		$scope.state = "default";

		$scope.checkIfColumnFilled = function(column)
		{
			var filled = 0;
			var cnt = 0;
			
			for(var i in $scope.calculator.items)
			{
				cnt++;
				var item = $scope.calculator.items[i];
				if(item[column]>0)
				{
					filled++;
				}
			}
			
			
			if(column=="rank_individual")
			{
				if(filled==cnt)
				{
					$scope.state = "step1_completed";
					return true;
				}
				else
				{
					$scope.state = "default";
					$scope.last_message = "";
					$scope.calculator.reveal_expert_rank = false;
				}
				//$scope.status = $scope.calculator.messages["rank_individual"];
			}
			else if(column=="rank_team")
			{
				if(filled==cnt)
				{
					$scope.state = "step2_completed";
					return true;
				}
				else
				{
					$scope.last_message = "";
					$scope.calculator.reveal_expert_rank = false;
				}
				//$scope.status = $scope.calculator.messages["rank_team"];
			}

			///return true;
			
			
			return false;
		}

		$scope.getRanks = function(x,node)
		{
			if(x==undefined || x==null)
			{
				return new Array();
			}
			var arr = new Array();
			//arr.push("None");
			var cnt = 0;

			var selectedRanks = new Array();
			for(var i in $scope.calculator.items)
			{
				//cnt++;
				selectedRanks.push($scope.calculator.items[i][x]);
				//arr.push(cnt);
			}
			console.log(selectedRanks);
			for(var i in $scope.calculator.items)
			{
				cnt++;
				if(selectedRanks.indexOf(cnt)==-1 || node[x]==cnt)
				{
					arr.push(cnt);
				}
			}
			return arr;
		}

		$scope.my_total = 0;
		$scope.team_total = 0;
		$scope.abs = function(x,n)
		{
			var y = Math.abs(x);
			if(n=="my_total")
			{
				$scope.my_total += y;
			}
			else if(n=="team_total")
			{
				$scope.team_total += y;
			}
			return y;
		};

		$scope.getItemsCount = function()
		{
			
			var cnt = 0;

			for(var i in $scope.calculator.items)
			{
				cnt++;
			}
			return cnt;
		}

		$scope.reveal = function()
		{
			var p = window.prompt("Enter the Password:");
			if(p==$scope.calculator.expert_rank_password)
			{
				$scope.calculator.reveal_expert_rank = true;
				$scope.last_message = $scope.calculator.messages["password_revealed"];
				$scope.state = "step3_completed";//$scope.calculator.messages["password_revealed"];
			}
		};

		$scope.getTotals = function(n)
		{	
			var tot = 0;
			for(var i in $scope.calculator.items)
			{
				var item = $scope.calculator.items[i];
				if(n=="team_total")
				{
					if(item.rank_team>0)
					{
						var diff = item.rank_expert - item.rank_team;
						diff = Math.abs(diff);
						$scope.team_total += diff;
						tot += diff;
					}
				}
				else if(n=="my_total")
				{
					if(item.rank_individual>0)
					{
						var diff = item.rank_expert - item.rank_individual;
						diff = Math.abs(diff);
						$scope.my_total += diff;
						tot += diff;
					}
				}
			}
			return tot;
		}

		$scope.status = "Fill in the Column 'Rank Individually' First";

		
	});



</script>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
<style>
	body
	{
		padding:50px;
		font-family: 'Roboto';
		font-size: 12px;
	}
	.twbs .row
	{
		margin-bottom: 5px;
	}
	.twbs label
	{
		    position: relative;
	    top: 8px;
	    font-size: 14px;
	}
	.twbs select
	{
		width: 100%;
		padding:4px;
		font-size:16px !important;
	}
	.twbs select.w90
	{
		width:90%;
	}
	.twbs .btn_reveal
	{
		cursor: pointer;
		display: inline-block;
	    background: #4fa523;
	    color: #fff;
	    font-weight: bold;
	    text-align: center;
	    width: 100%;
	    padding: 5px;
	    border-radius: 5px;
	}
	.twbs .row.header
	{
		font-weight: bold;
		margin-bottom: 20px;
	}
	.twbs .row.header .col-md-2
	{
		font-size: 14px;
    	color: #be0000;
    	text-transform: uppercase;
    	text-align: center;
	}
	.twbs .aleft
	{
		text-align: left !important;
	}
	.twbs .center.bold
	{
		text-align: center;
		font-size:14px;
		font-weight: bold;
	}
	.twbs .clear_box
	{
		width: 10%;
	    text-align: center;
	    background: #eb0a0a;
	    color: #fff;
	    position: absolute;
	    top: 50%;
	    transform: translateY(-50%);
	    font-size: 10px;
	    padding-top: 5px;
	    padding-bottom: 5px;
	    border-top-right-radius: 10px;
	    border-bottom-right-radius: 10px;
	    font-weight: bold;
	    cursor: pointer;

	}
	.twbs .clear_box:hover
	{
		opacity: 0.7;
	}
	.twbs .totals
	{
		color:#000;
	}
	.twbs .totals div.head
	{
		font-size: 14px;
    	color: #ad0d0d;
	}
	.twbs .totals div.cnt
	{
		font-size: 30px;
    	font-weight: bold;
    	color: #000;
	}
</style>
<link rel="stylesheet" type="text/css" href="twbs.css" />
<body>
	<div ng-app="ItemCalculator" ng-controller="MainController" class="twbs">

		<div class="row">
			<div class="col-md-12 status"><span ng-show="state=='default' && last_message==''">{{calculator.messages["default"]}}</span><span ng-show="state=='step1_completed' && last_message==''">{{calculator.messages["rank_individual"]}}</span><span ng-show="state=='step2_completed' && last_message==''">{{calculator.messages["rank_team"]}}</span><span ng-show="last_message!=''">{{calculator.messages["password_revealed"]}}</span></div>
		</div>
		<div class="row header">
			<div class="col-md-2 aleft">Items to pack</div>
			<div class="col-md-2">Rank Individually</div>
			<div class="col-md-2">Rank as a Team</div>
			<div class="col-md-2">Expert Rankings</div>
			<div class="col-md-2">Your Difference</div>
			<div class="col-md-2">Team Difference</div>
		</div>

		

		<div class="row" ng-repeat="(name,item) in calculator.items">
			<div class="col-md-2"><label for="dd{{$index}}">{{item.label}}</label></div>

			<div class="col-md-2" ng-class="{filled:checkIfColumnFilled('rank_individual')}">
				<select id="dd{{$index}}" tabindex="{{$index}}" ng-model="calculator.items[name].rank_individual" ng-options="item as item for item in getRanks('rank_individual',calculator.items[name])" ng-class="{w90:true}"></select><span ng-click="calculator.items[name].rank_individual=-1" ng-show="calculator.items[name].rank_individual>0" class="clear_box">X</span></div>

			<div class="col-md-2"><select tabindex="{{$index+getItemsCount()}}" ng-disabled="!checkIfColumnFilled('rank_individual')" ng-model="calculator.items[name].rank_team" ng-options="item as item for item in getRanks('rank_team',calculator.items[name])" ng-class="{w90:true}"></select><span ng-click="calculator.items[name].rank_team=-1" ng-show="calculator.items[name].rank_team>0" class="clear_box">X</span></div>

			<div class="col-md-2 center bold"><span ng-click="reveal()" ng-show="checkIfColumnFilled('rank_team') && !calculator.reveal_expert_rank && $index==0" class="btn_reveal">Reveal</span><span ng-show="calculator.reveal_expert_rank">{{calculator.items[name].rank_expert}}</span></div>

			<div class="col-md-2 center bold"><span ng-show="calculator.items[name].rank_individual>0 && calculator.reveal_expert_rank" ng-bind="abs(calculator.items[name].rank_individual - calculator.items[name].rank_expert,'my_total')"></span></div>

			<div class="col-md-2 center bold"><span ng-show="calculator.items[name].rank_team>0 && calculator.reveal_expert_rank" ng-bind="abs(calculator.items[name].rank_team - calculator.items[name].rank_expert,'team_total')"></span></div>
		</div>


		<div class="row">
			<div class="col-md-2">&nbsp;</div>

			<div class="col-md-2"	>&nbsp;</div>

			<div class="col-md-2">&nbsp;</div>

			<div class="col-md-2 center bold">&nbsp;</div>

			<div class="col-md-2 center bold">
				<div class="totals" ng-show="calculator.reveal_expert_rank">
					<div class="head">Individual Score</div>
					<div class="cnt"><span ng-bind="getTotals('my_total')"></span></div>
				</div>
			</div>

			<div class="col-md-2 center bold">
				<div class="totals" ng-show="calculator.reveal_expert_rank">
					<div class="head">Team Score</div>
					<div class="cnt"><span ng-bind="getTotals('team_total')"></span></div>
				</div>
			</div>
		</div>



		</div>

</body>