using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Codedigm.Web.Helpers
{
    public static class StringExtensions
    {
        public static string SplitByCapitalLetter(this string str)
            => string.Concat(str.Select(x => char.IsUpper(x) ? " " + x : x.ToString())).TrimStart(' ');
    }
}