@extends('report.pdf.layout')
@section('title', 'Payslip')
@section('content')
<div class="row">
    <center><strong>{{$date->flag=='C'?'':'(Tentative)'}}</strong></center>
    <div class="col-md-12 mt-2">
        <span style="text-align: right;">
            Pay Period: <strong>{{date('F Y',strtotime($date->pay_period))}} </strong><br>
        </span>
        <hr>
        <table class="table table-sm noBorder" style="border: none;">
            <thead>
                <tr>
                    <th align="center" colspan="4">Employee Details</th>
                </tr>
                <tr>
                    <td class="noBorder">Employee ID</td>
                    <td width="30%" class="noBorder">{{$report->Employee->employee_id}}</td>
                    <td class="noBorder">Designation</td>
                    <td width="30%" class="noBorder">{{$report->Employee->Designation->designation}}</td>
                </tr>
                <tr>
                    <td class="noBorder">Employee Name</td>
                    <td class="noBorder">{{$report->Employee->name}}</td>
                    <td class="noBorder">Department</td>
                    <td class="noBorder">{{$report->Employee->Department->department}}</td>
                </tr>
                <tr>
                    <td class="noBorder">CID Number</td>
                    <td class="noBorder">{{$report->Employee->cid_number}}</td>
                    <td class="noBorder">Appoinment Date</td>
                    <td class="noBorder">{{date('d-m-Y',strtotime($report->Employee->appointment_date))}}</td>
                </tr>
                <tr>
                    <th align="center" colspan="2">Earning</th>
                    <th align="center" colspan="2">Deduction</th>
                </tr>
                <tr>
                    <td class="noBorder">Basic Pay</td>
                    <td class="noBorder">{{number_format($report->basic_pay,2)}}</td>
                    <td class="noBorder">Health Contribution</td>
                    <td class="noBorder">{{number_format($report->health_contribution,2)}}</td>
                </tr>
                <tr>
                    <td class="noBorder">Allowance</td>
                    <td class="noBorder">{{number_format($report->allowance,2)}}</td>
                    <td class="noBorder">Provident Fund</td>
                    <td class="noBorder">{{number_format($report->provident_fund,2)}}</td>
                </tr>
                <tr>
                    <td><b>Total Earnings</b></td>
                    <td>
                        {{number_format($report->basic_pay+$report->allowance,2)}}
                    </td>

                    <td class="noBorder">Tax</td>
                    <td class="noBorder">{{number_format($report->tax,2)}}</td>
                </tr>

                <tr>
                    <td colspan="2"></td>
                    <td>
                        <b>Total Deductions</b>
                    </td>
                    <td>
                        {{number_format($report->health_contribution+$report->provident_fund+$report->tax,2)}}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><b>Net Pay:&nbsp;</b></td>
                    <td colspan="2">
                        <b>{{number_format(($report->basic_pay+$report->allowance)-($report->health_contribution+$report->provident_fund+$report->tax),2)}}</b>
                        <hr>
                    </td>
                </tr>
            </thead>
        </table>

    </div>
</div>
@endsection