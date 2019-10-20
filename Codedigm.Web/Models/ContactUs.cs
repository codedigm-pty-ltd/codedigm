using Codedigm.Web.Helpers;
using System;
using System.Text;

namespace Codedigm.Web.Models
{
    public class ContactUs
    {
        public string Name { get; set; }
        public string Email { get; set; }
        public string CompanyName { get; set; }
        public int CompanySizeId { get; set; }
        public int ServiceId { get; set; }
        public string Subject { get; set; }
        public string Message { get; set; }

        public override string ToString()
        {
            StringBuilder stringBuilder = new StringBuilder();

            stringBuilder.AppendLine($"Name: {Name}");
            stringBuilder.AppendLine($"Email: {Email}");
            stringBuilder.AppendLine($"Company Name: {CompanyName}");
            stringBuilder.AppendLine($"Company Size: {Enum.GetName(typeof(CompanySizeEnum), CompanySizeId).SplitByCapitalLetter()}");
            stringBuilder.AppendLine($"Service: {Enum.GetName(typeof(ServiceEnum), ServiceId).SplitByCapitalLetter()}");
            stringBuilder.AppendLine($"Message: {Message}");

            return stringBuilder.ToString();
        }
    }
}