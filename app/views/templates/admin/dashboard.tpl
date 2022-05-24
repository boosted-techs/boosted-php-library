{extends file="admin/index.tpl"}
{block name="body"}
    <div class="row">
        <div class="col-md-12 mt-2 mb-5">
            <button class="btn btn-info mr-2" onclick="addSmsRate()">ADD SMS RATES</button>
            <button class="btn btn-outline-warning" onclick="addAcceptedCurrency()">ADD CURRENCY</button>
        </div>
        <div class="col-md-5 card mr-2">
            <div class="card-header">
                <h5 class="card-title">CHARGES</h5>
                <button class="btn btn-outline-info float-right" onclick="addCharges()">ADD CHARGES</button>
            </div>
            <div class="card-body">
                <small>These charges apply to withdraw and Deposits from API</small>
                <table class="table">
                    <thead>
                    <tr>
                        <th>DEPOSIT</th>
                        <th>Withdraw</th>
                        <th>USERNAME</th>
                        <th>DATE ADDED</th>
                    </tr>
                    </thead>
                    <tbody>
                        {if ! empty($deposit_charges)}
                            <tr>
                                <td>{$deposit_charges.deposit_charge}</td>
                                <td>{$deposit_charges.withdraw_charge|number_format}</td>
                                <td>{$deposit_charges.username}</td>
                                <td>{$deposit_charges.date_added}</td>
                            </tr>
                        {/if}
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6 card shadow-sm">
            <div class="card-header">
                <h5 class="card-title">APP UPDATES</h5>
                <a href="/admin/update-app-v">
                    <button class="btn btn-outline-danger float-right">UPDATE APP</button>
                </a>
            </div>
            <div class="card-body">
                <small>Show current App Version</small>
                <table class="table">
                    <thead>
                    <tr>
                        <th>VERSION</th>
                        <th>DATE OF UPDATE</th>
                    </tr>
                    </thead>
                    <tbody>
                       {if ! empty($app_version)}
                           <tr>
                               <td>{$app_version.id}</td>
                               <td>{$app_version._timestamp}</td>
                           </tr>
                       {/if}
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-5 table-responsive">
            <h5 class="">SMS RATES</h5>
            <table class="table shadow table-hover table-warning w-100">
                <thead>
                    <tr>
                        <th></th>
                        <th>Currency</th>
                        <th>Country Code</th>
                        <th>BP</th>
                        <th>SP</th>
                        <td>Date-added</td>
                    </tr>
                </thead>
                <tbody>
                    {foreach $sms_rates as $item name="currency"}
                        <tr>
                            <td>{$smarty.foreach.currency.index + 1}</td>
                            <td>{$item.currency}</td>
                            <td>{$item@key}</td>
                            <td>{$item.buying_price}</td>
                            <td>{$item.selling_price}</td>
                            <td>{$item.date_added}</td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
        <div class="col-md-7 table-responsive">
            <h5 class="">Accepted Currencies</h5>
            <table class="table shadow table-hover w-100 bg-danger">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        {foreach $accepted_currencies as $currency}
                            <th>{$currency}</th>
                        {/foreach}
                    </tr>
                </thead>
                <tbody>
                    {foreach $fx_rates as $rates name="fx"}
                        <tr>
                            <td>{$smarty.foreach.fx.index + 1}</td>
                            <td>{$rates@key}</td>
                            {foreach $fx_rates[$rates@key] as $fx}
                                <td>{$fx}</td>
                            {/foreach}
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
        <div class="col-md-12 p-2">
            <h5 class="">USERS</h5>
            <div class="table-responsive">
            <table class="table shadow">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Details</th>
                        <th>Gender</th>
                        <th>Country</th>
                        <th>Date added</th>
                        <th>Last edit</th>
                    </tr>
                </thead>
                {foreach $users as $user}
                    <tbody>
                        <tr>
                            <td>{$user@key + 1}</td>
                            <td><img src="{$user.image}" style="width: 50px; height: 50px; object-fit: contain"/></td>
                            <td>{$user.names}</td>
                            <td> {$user.username}</td>
                            <td>{$user.email}</td>
                            <td>
                                Orgs - {$user.organizations}
                               <br/>
                                Pros - {$user.projects}
                                <br/>
                                Cols- {$user.collaborations}
                            </td>
                            <td>{$user.gender}</td>
                            <td>{$user.city} - {$user.country}</td>
                            <td>{$user.date_added}</td>
                            <td>{$user._timestamp}</td>
                        </tr>
                    </tbody>
                {/foreach}

            </table>
            </div>
        </div>
        <div class="col-md-12">
            <h5>Organizations</h5>
            <div class="table-responsive">
                <table class="table shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <Th>Name</Th>
                            <th>Url</th>
                            <th>Address</th>
                            <th>Website</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Deleted</th>
                            <th>Projects</th>
                            <th>Date added</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $organizations as $value}
                            <tr>
                                <td>{$value@key + 1}</td>
                                <td><img src="/profile_pics/{$value.logo}" style="width: 45px; height:45px; object-fit: contain"/></td>
                                <td>{$value.name} {if $value.verified == 1}<i class="fa fa-check-circle text-info"></i> {/if}</td>
                                <td>{$value.url}</td>
                                <td style="word-break: break-word">{$value.address}</td>
                                <td style="word-break: break-all">{$value.website}</td>
                                <td>{$value.email}</td>
                                <td>{$value.contacts}</td>
                                <td>{$value.status}</td>
                                <td>{$value.deleted}</td>
                                <td>{$value.projects}</td>
                                <td>{$value.date_added}</td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <h5>Projects</h5>

            <div class="table-responsive">
                <table class="table shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <Th>Name</Th>
                            <th>TYPE</th>
                            <th>STATE</th>
                            <th>Description</th>
                            <th>URL</th>
                            <td></td>
                            <th>Creator</th>
                            <th>Namespace</th>
                            <th>Url</th>
                            <th>Collections</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $projects as $value}
                            <tr>
                                <td>{$value@key + 1}</td>
                                <td>{$value.project}</td>
                                <td>{if $value.project_type == 1}<span class="badge badge-info"><i class="fa fa-envelope"></i></span>{else}<span class="badge badge-success"><i class="fa fa-money"></i></span>{/if}</td>
                                <td><span class="badge badge-warning">STATUS: {if $value.status == 1}VISIBLE{/if}</span> <br/> <span class="badge badge-info">PROD : {if $value.live == 1}LIVE{/if}</span> <br/><span class="badge badge-danger">DELETED: {if $value.deleted == 1}DELETED{/if}</span></td>
                                <td>{$value.description}</td>
                                <td>{$value.url}</td>
                                <td><img src="{$value.image}" style="width: 50px; height: 50px; object-fit: contain"/></td>
                                <td><b>{$value.names}</b> - {$value.username}</td>
                                <td>{$value.namespace}</td>
                                <td>{$value.namespace_url}</td>
                                <td>{$value.collection_tx}</td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<script>
    const currencies = {json_encode($accepted_currencies)}
</script>
{/block}