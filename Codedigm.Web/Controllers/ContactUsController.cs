using Codedigm.Web.Models;
using System;
using System.Collections.Generic;
using System.Configuration;
using System.IO;
using System.Linq;
using System.Net;
using System.Net.Configuration;
using System.Net.Http;
using System.Net.Mail;
using System.Threading.Tasks;
using System.Web;
using System.Web.Configuration;
using System.Web.Http;
using System.Web.Http.Results;

namespace Codedigm.Web.Controllers
{
    public class ContactUsController : ApiController
    {
        // POST: api/ContactUs
        public async Task Post([FromBody]ContactUs contactUs)
        {
            try
            {           
                var message = new MailMessage();
               //TODO: save to db.
                message.From = new MailAddress("info@codedigm.co.za");
                message.To.Add(new MailAddress("info@codedigm.co.za"));
                message.Subject = $"Company Website Lead - {contactUs.Subject}";
                message.Priority = MailPriority.High;
                message.Body = contactUs.ToString();
                //message.IsBodyHtml = true;
                using (var smtp = new SmtpClient())
                {
                    await smtp.SendMailAsync(message);
                    await Task.FromResult(0);
                }

            }
            catch (Exception ex)
            {
                //TODO: handle this better.
                throw;
            }
        }

        //TODO: later when we have an email format.
        private string createEmailBody(ContactUs contactUs)
        {
            string body = string.Empty;

            using (StreamReader reader = new StreamReader(HttpContext.Current.Server.MapPath("/htmlTemplate.html")))
            {
                body = reader.ReadToEnd();
            }
            //body = body.Replace("{UserName}", userName);
            //body = body.Replace("{message}", message);
            return body;
        }
    }
}
