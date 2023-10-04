
export const entityLeadCreateForm = (form) => {

   // return null

   const count = 2;

   const countLen = count.toString().split('').length
   const cif = '000000000'.substr(0, 9 - countLen) + count;
   const telCompany = '00000000'.substr(0, 9 - countLen) + count;
   const telContact = '00000000'.substr(0, 9 - countLen) + count;

   // Company
   form.company_name.value = `company_name ${count}`;
   form.company_legal_representative_name.value = `company_legal_representative_name ${count}`;
   form.company_tax_number.value = cif;
   form.company_email.value = `company_email${count}@gmail.com`;
   form.company_phone.value = telCompany;
   form.company_country.value = `company_country ${count}`;
   form.company_province.value = `company_province ${count}`;
   form.company_city.value = `company_city ${count}`;
   form.company_pc.value = `pc11${count}`;
   form.company_address.value = `company_address ${count}`;
   form.company_acquisition.value = 'google';
   form.company_interests.value = ['New Genius', 'New Genius Flash Point'];
   form.company_competitors.value = ['BFlash'];
   form.company_notes.value = `company_notes ${count}`;

   // Contact
   form.contact_name.value = `contact_name ${count}`;
   form.contact_email.value = `contact_email${count}@gmail.com`;
   form.contact_phone.value = telContact;
   form.contact_position.value = `contact_position ${count}`;
   form.contact_channel.value = 'phone'
   form.contact_observations.value = `contact_observations ${count}`;


}