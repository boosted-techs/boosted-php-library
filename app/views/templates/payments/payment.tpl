<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    {if ! empty($project)}
        <title>{if isset($smarty.get.names)} {$project.org.name}'s wallet topup to {$smarty.get.names|ucwords} {else}{$project.org.name}'s E-wallet{/if}</title>
        <meta name="description" content="{if isset($smarty.get.names)}Hello {$smarty.get.names|ucwords}, I kindly request you to drop something{if isset($smarty.get.amount)} of {$smarty.get.amount} {/if} {if isset($smarty.get.reason)}for {$smarty.get.reason}{/if} on my wallet. Thanks {else}{$project.org.name}'s Boosted - Wallet. Collect money online with Boosted Payment's Gateway{/if} "/>
    {else}
        <title>Boosted Payments Gateway</title>
        <meta name="description" content="Collect money online with Boosted's Payments Gateway"/>
    {/if}
    <meta name="theme-color" content="#009c51"/>
    <link href="/assets/p/vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Favicon icon -->
    <link rel="icon" href="/assets/image/favicon.png" type="image/png">
    <link href="/assets/p/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
</head>

<body class="h-100">
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6">
                <div class="authincation-content">
                    <div class="row no-gutters">
                        <div class="col-xl-12">
                            <div class="auth-form">
                                {if ! empty($project)}
                                    <div class="text-center mb-3">
{*                                        <a href=""><img src="/profile_pics/{$project.org.logo}"  style="width:50px; object-fit: contain" alt="Boosted Logo"></a>*}
                                        <h3 class="text-white p-3">
                                            {$project.org.name}
                                            {if $project.org.verified == 1}<i class="fa fa-check-circle text-dark"></i>
                                            {/if}
                                        </h3>
                                        <h6 class="text-white">[{$project.project}]</h6>
                                        <p class="text-white"><small>{$project.org.email} <br/> {$project.org.contacts}</small><Br/><small class="text-dark">[{$project.description}]</small></p>
                                    </div>
                                    <h4 class="text-center mb-4 text-white">E-Wallet</h4>
                                    <form action="index.html" id="form" onsubmit="return false">
                                        {if $project.live == 0 or $project.org.status == 0}
                                            <h4 class="text-center text-white">
                                                The user is not live to accept payments at this time. If you are the account owner, make sure project and namespace collecting funds are all Live to production.
                                            </h4>
                                        {else}
                                            <div class="form-group">
                                                <label class="mb-1 text-white"><strong>NAMES</strong></label>
                                                <input type="text" name="names" {if isset($smarty.get.names)} value="{$smarty.get.names}" {if ! isset($smarty.get.nostrict)} disabled {/if} {/if} class="form-control" required placeholder="Names">
                                                {if isset($smarty.get.names) && ! isset($smarty.get.nostrict)} <input type="hidden" name="names" value="{$smarty.get.names}"/> {/if}
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-1 text-white"><strong>Email</strong></label>
                                                <input type="email" name="email" {if isset($smarty.get.email)} value="{$smarty.get.email}" {if ! isset($smarty.get.nostrict)} disabled {/if} {/if} class="form-control" placeholder="hello@example.com">
                                                {if isset($smarty.get.email) && ! isset($smarty.get.nostrict)} <input type="hidden" name="email" value="{$smarty.get.email}"/> {/if}
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-1 text-white"><strong>Phone number to withdraw from</strong></label>
                                                <div class="input-group">
                                                    <select class="input-group-append" name="code">
                                                        <option value="256">+256</option>
                                                    </select>
                                                    <input type="number" name="phone_number" class="form-control" required {if isset($smarty.get.phone)} value="{$smarty.get.phone}" {if ! isset($smarty.get.nostrict)} disabled {/if} {/if} placeholder="Phone number">
                                                    {if isset($smarty.get.phone) && ! isset($smarty.get.nostrict)} <input type="hidden" name="phone_number" value="{$smarty.get.phone}"/> {/if}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-1 text-white"><strong>Amount (UGX)</strong></label>
                                                <input type="number" name="amount" {if isset($smarty.get.amount)} value="{$smarty.get.amount}" {if ! isset($smarty.get.nostrict)} disabled {/if} {else} required {/if} class="form-control" placeholder="Amount to be collected">
                                                {if isset($smarty.get.amount) && ! isset($smarty.get.nostrict)} <input type="hidden" name="amount" value="{$smarty.get.amount}"/> {/if}
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-1 text-white"><strong>Reason for payment</strong></label>
                                                <textarea name="comment" class="form-control" {if isset($smarty.get.reason)}  {else} required {/if} placeholder="Reason for Payment">{if isset($smarty.get.reason)}{$smarty.get.reason}{/if}</textarea>
                                                {if isset($smarty.get.reason) && ! isset($smarty.get.nostrict)}
                                                    <input type="hidden" value="{$smarty.get.reason}" name="comment"/>
                                                {/if}
                                                <input type="hidden" name="project" value="{$project.url}"/>
                                            </div>
                                            <div class="text-center mt-4">
                                                <button type="submit" class="btn bg-white text-primary btn-block" onclick="paySlip()">PAY USING MOBILE MONEY</button>
                                            </div>
                                        {/if}
                                    </form>
                                {else}
                                    <h4 class="text-white text-center">PAYMENT LINK NOT FOUND.</h4>
                                {/if}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--**********************************
	Scripts
***********************************-->
<!-- Required vendors -->
<script src="/assets/axios/axios.js"></script>
<script src="/assets/p/vendor/global/global.min.js"></script>
<script src="/assets/p/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="/assets/p/js/custom.min.js"></script>
<script src="/assets/p/js/deznav-init.js"></script>
<script src="/assets/p/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
<script>
    {literal}
        function paySlip() {
            let form = document.forms.form
            let formData = new FormData(form)
            $("input").attr("disabled", true)
            $("button").attr("disabled", true)
            axios({
                data : formData,
                url : "/pay/pay-slip",
                method : "post"
            }) .
                then(function(e) {
                let data = e.data
                swal(data.status, data.message)
                $("input").attr("disabled", false)
                if (data.code === 200) {
                    $("input").val('')
                    $("textarea").val()
                }
                $("button").attr("disabled", false)
            })
        }
    {/literal}
</script>
</body>
</html>