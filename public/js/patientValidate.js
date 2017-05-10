function validate() {
	validator = $("#registrationForm").bootstrapValidator({
				fields: {
					email : {
						message: "Potreben je email naslov",
						validators : {
							notEmpty : {
								message: "Vnesite email naslov"
							},
							emailAddress: {
								message: "Email naslov naslov ni pravilne oblike"
							}
						}
					},
					name: {
						validators: {
							notEmpty: {
								message: "Vnesite ime"
							},
							regexp: {
								message: "Ime lahko vsebuje le črke"
							},
							stringLength: {
								min: 2,
								max: 20,
								message: "Priimek je lahko dolg najmanj 2 in največ 20 znakov."
							}
						}
					},
					surname:{
						validators: {
							notEmpty: {
								message: "Vnesite priimek"
							},
							regexp: {
								message: "Priimek lahko vsebuje le črke"
							},
							stringLength: {
								min: 2,
								max: 20,
								message: "Priimek je lahko dolg najmanj 2 in največ 20 znakov."
							}
						}
					},
					postNumber: {
						validators: {
							notEmpty: {
								message: "Izberite poštno številko"
							}
						}
					},
					region: {
						validators: {
							notEmpty:  {
								message: "Izberite šifro okoliša"
							}
						}
					},
					address: {
						validators: {
							notEmpty: {
								message: "Vnesite naslov"
							}
						}
					},
					relationship: {
						validators: {
							notEmpty: {
								message: "Izberite sorodstveno razmerje"
							}
						}
					},
					birthDate: {
						validators: {
							notEmpty: {
								message: "Vnesite datum rojstva"
							}
						}
					},
					sex: {
						validators: {
							notEmpty: {
								message: "Izberite spol"
							}
						}
					}


				}
			});
}
$(document).ready(function (){
	validate();
});