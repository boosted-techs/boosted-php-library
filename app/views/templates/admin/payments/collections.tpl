{extends file="admin/index.tpl"}
{block name="body"}
    <div class="row">
        <a href="/admin/transactions/collections.boosted?t=mm">
            <btn class="btn btn-outline-info">MOBILE MONEY</btn>
        </a>
        <a class="ml-2" href="/admin/transactions/collections.boosted?t=card">
            <btn class="btn btn-outline-danger">ELECTRONIC CARD</btn>
        </a>
       <div class="table-responsive">
            <table class="table table-striped shadow">
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th>Namespace</th>
                    <th>Project</th>
                    <th style="width:200px">TRANSACTION</th>
                    <th>Phone</th>
                    <th>Initiated</th>
                    <th>Deposited</th>
                    <th>STATUS</th>


                    <th>OWNER</th>

                    <th>Date</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    {foreach $collections as $tx}
                        <tr>
                            <td>{$tx@key + 1}</td>
                            <td>
                                {if ! empty($tx.namespace_image)}
                                    <img src="/profile_pics/{$tx.namespace_image}" style="width: 30px" />
                                {/if}
                            </td>
                            <td>{$tx.namespace}</td>
                            <td>{$tx.project_name}</td>
                            <td style="word-break: break-all">{$tx.boosted_tx_ref}</td>
                            <td>{$tx.phone_number}</td>
                            <td>{$tx.amount}</td>
                            <td>{$tx.available_amount}</td>
                            <td>
                                {if $tx.status == 1}
                                    <span class="badge badge-success">Completed</span>
                                {elseif $tx.status == 0}
                                    <span class="badge badge-danger">Failed</span>
                                {elseif $tx.status == 2}
                                    <span class="badge badge-info">Pending</span>
                                {else}
                                    XX
                                {/if}
                            </td>

                            <td>{$tx.user_names}</td>
                            <td>{$tx.date_added}</td>
                            <Td>{$tx._request}</Td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
       </div>
    </div>
{/block}