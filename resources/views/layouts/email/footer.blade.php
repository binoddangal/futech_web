
<tr>
    <td style="padding: 30px 0; background-color: #F5F5F5 ; color: #fff;">

        <!-- Tables are the most common way to format your email consistently. Set your table widths inside cells and in most cases reset cellpadding, cellspacing, and border to zero. Use nested tables as a way to space effectively in your message. -->
        <table cellpadding="0" cellspacing="0" border="0" align="center" class="container" style="">
            <tr>
                <td width="40%" valign="top">
                    <h3 style="margin-bottom: 10px; color: #fff;">Explore</h3>

                </td>
                <td width="40%" valign="top">
                    <ul style="margin: 0; padding-bottom: 0; list-style: none;">

                    </ul>
                </td>

            </tr>
        </table>
        <!-- End example table -->

    </td>
</tr>
<tr>
    <td style="padding: 30px 0; background-color: #F5F5F5; color: #000000">

        <!-- Tables are the most common way to format your email consistently. Set your table widths inside cells and in most cases reset cellpadding, cellspacing, and border to zero. Use nested tables as a way to space effectively in your message. -->
        <table cellpadding="0" cellspacing="0" border="0" align="center" class="container" style="">

            <tr>
                <td style="width: 20%">
                    <a target="_blank" href="#">
                        @if (getSetting() && getSetting()->logo_path && getSetting()->logo_path['real'])
                            <img src="{{getSetting()->logo_path['real']}}" width="150px" class="logo"/>
                        @else
                            <img src="{{asset('ashwinifoundation/images/ashwini_logo.png')}}" width="60px" class="logo"/>
                        @endif
                    </a>
                </td>
                <td width="80%" style="margin-top: 4px soli #fff;">
                    <p style="text-align:center; color: #000000;"> {{ date('Y') }} &copy; All rights reserved
                        <br/>Powered by <a href="https://futech.com" style="color: #000000;" target="_blank" class="text-white">futech</a>
                    </p>
                </td>
            </tr>
        </table>
        <!-- End example table -->

    </td>
</tr>
</table>
</body>
</html>

