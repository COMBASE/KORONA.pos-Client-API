/**
 * COMBASE KORONA.pos Client - Plugin API - JavaScript module
 * Version 1.0.0
 */
korona_plugin_api = new function() {

	this.response = new function() {

		this.actions = [];

		this.application = { key: null, version: null };

		this.modified = function(handler) {
			if (typeof handler === 'function')
				this.modified.notify = handler;
			return this.modified;
		};
		this.modified.notify = function() { };

		this.identifyAs = function(key, version) {
			this.application.key = key;
			this.application.version = version;
			this.modified.notify();
			return this;
		};

		this.startActions = function() {
			this.actions = [];
			this.modified.notify();
			return this;
		};

		this.removeAction = function(paramObj) {
			if (typeof paramObj === 'undefined')
				return this;
			if (typeof paramObj !== 'number')
				this.removeAction(this.actions.indexOf(paramObj));
			if (paramObj < 0 || paramObj >= this.actions.lenght)
				return this;
			this.actions.splice(paramObj, 1);
			this.modified.notify();
			return this;
		}

		this.addAccountTransaction = function(paramObj) {
			this.actions.push({
				type: 'addAccountTransactionAction',
				accountNumber: paramObj.accountNumber,
				amount: paramObj.amount,
				fixedAmount: paramObj.fixedAmount,
				notRemovable: paramObj.notRemovable,
				customData: paramObj.customData
			});
			this.modified.notify();
			return this;
		};

		this.addPayment = function(paramObj) {
			if (typeof paramObj === 'string')
				paramObj = {inputAmount: paramObj};
			this.actions.push({
				type: 'addPaymentAction',
				inputAmount: paramObj.inputAmount,
				paymentMethodNumber: paramObj.paymentMethodNumber,
				customData: paramObj.customData
			});
			this.modified.notify();
			return this;
		};

		this.addSale = function(paramObj) {
			if (typeof paramObj === 'string')
				paramObj = {recognitionCode: paramObj};
			this.actions.push({
				type: 'addSaleAction',
				discount: this.createDiscountAction(paramObj.discount),
				infoTexts: paramObj.infoTexts,
				price: paramObj.price,
				quantity: paramObj.quantity,
				recognitionCode: paramObj.recognitionCode,
				useAlternativeSector: paramObj.useAlternativeSector,
				customData: paramObj.customData
			});
			this.modified.notify();
			return this;
		};

		this.displayMessage = function(paramObj) {
			if (typeof paramObj === 'string')
				paramObj = {text: paramObj};
			this.actions.push({
				type: 'displayMessageAction',
				level: paramObj.level,
				text: paramObj.text,
				title: paramObj.title
			});
			this.modified.notify();
			return this;
		};

		this.logMessage = function(paramObj) {
			if (typeof paramObj === 'string')
				paramObj = {text: paramObj};
			this.actions.push({
				type: 'logMessageAction',
				level: paramObj.level,
				text: paramObj.text
			});
			this.modified.notify();
			return this;
		};

		this.modifyAccountTransaction = function(paramObj) {
			this.actions.push({
				type: 'modifyAccountTransactionAction',
				modifier: paramObj.modifier,
				amount: paramObj.amount,
				fixedAmount: paramObj.fixedAmount,
				notRemovable: paramObj.notRemovable,
				customData: paramObj.customData
			});
			this.modified.notify();
			return this;
		};

		this.modifyPayment = function(paramObj) {
			this.actions.push({
				type: 'modifyPaymentAction',
				modifier: paramObj.modifier,
				customData: paramObj.customData
			});
			this.modified.notify();
			return this;
		};

		this.modifySale = function(paramObj) {
			this.actions.push({
				type: 'modifySaleAction',
				modifier: paramObj.modifier,
				discount: this.createDiscountAction(paramObj.discount),
				infoTexts: paramObj.infoTexts,
				price: paramObj.price,
				quantity: paramObj.quantity,
				useAlternativeSector: paramObj.useAlternativeSector,
				customData: paramObj.customData
			});
			this.modified.notify();
			return this;
		};

		this.printMessage = function(paramObj) {
			if (typeof paramObj === 'string')
				paramObj = {text: paramObj};
			this.actions.push({
				type: 'printMessageAction',
				text: paramObj.text,
				title: paramObj.title,
				qrCode: paramObj.qrCode,
				code39Barcode: paramObj.code39Barcode,
				printFooter: paramObj.printFooter,
				printHeader: paramObj.printHeader
			});
			this.modified.notify();
			return this;
		};

		this.removeReceiptItem = function(paramObj) {
			if (typeof paramObj === 'string')
				paramObj = {modifier: parseInt(paramObj)};
			else if (typeof paramObj === 'number')
				paramObj = {modifier: paramObj | 0};
			this.actions.push({
				type: 'removeReceiptItemAction',
				modifier: paramObj.modifier
			});
			this.modified.notify();
			return this;
		};

		this.setInputLine = function(paramObj) {
			if (typeof paramObj === 'string')
				paramObj = {value: paramObj};
			this.actions.push({
				type: 'setInputLineAction',
				value: paramObj.value
			});
			this.modified.notify();
			return this;
		};

		this.setReceiptCustomer = function(paramObj) {
			if (typeof paramObj === 'string')
				paramObj = {number: paramObj};
			this.actions.push({
				type: 'modifyReceiptAction',
				customer: {
					address: this.createAddress(paramObj.address),
					alternativePhone: paramObj.alternativePhone,
					birthday: paramObj.birthday,
					company: paramObj.company,
					fax: paramObj.fax,
					firstName: paramObj.firstName,
					gender: paramObj.gender,
					lastName: paramObj.lastName,
					number: paramObj.number,
					phone: paramObj.phone,
					salutation: paramObj.salutation,
					title: paramObj.title
			}});
			this.modified.notify();
			return this;
		};

		this.setReceiptDiscount = function(paramObj) {
			this.actions.push({
				type: 'modifyReceiptAction',
				discount: this.createDiscountAction(paramObj)
			});
			this.modified.notify();
			return this;
		};

		this.setReceiptCustomData = function(paramObj) {
			if (typeof paramObj === 'string')
				paramObj = {customData: paramObj};
			this.actions.push({
				type: 'modifyReceiptAction',
				customData: paramObj.customData
			});
			this.modified.notify();
			return this;
		};

		this.callExternalSystem = function(paramObj) {
			if (typeof paramObj === 'string')
				paramObj = {displayUrl: paramObj};
			this.actions.push({
				type: 'callExternalSystemAction',
				displayUrl: paramObj.displayUrl,
				displayUrlPost: paramObj.displayUrlPost,
				systemUrl: paramObj.systemUrl,
				login: paramObj.login,
				password: paramObj.password,
				connectTimeoutMillis: paramObj.connectTimeoutMillis,
				readTimeoutMillis: paramObj.readTimeoutMillis
			});
			this.modified.notify();
			return this;
		};

		this.unsetReceiptCutomer = function() {
			this.actions.push({
				type: 'modifyReceiptAction',
				unsetCustomer: true
			});
			this.modified.notify();
			return this;
		};

		this.createAddress = function(paramObj) {
			if (typeof paramObj === 'undefined' || paramObj === null)
				return undefined;
			return {
				city: paramObj.city,
				country: paramObj.country,
				line1: paramObj.line1,
				line2: paramObj.line2,
				postalCode: paramObj.postalCode,
				state: paramObj.state
			};
		};

		this.createDiscountAction = function(paramObj) {
			if (typeof paramObj === 'undefined' || paramObj === null)
				return undefined;
			if (typeof paramObj === 'number')
				paramObj = {amount: paramObj};
			else if (typeof paramObj.percent === 'number')
				paramObj = {amount: paramObj.percent, percent: true};
			return {
				amount: paramObj.amount,
				percent: paramObj.percent
			};
		};

		this.toJson = function() {
			return JSON.stringify(this);
		};
	};

	this.request = null;

	this.ready = function(handler) {
		if (typeof handler === 'function')
			this.ready.notify = handler;
		return this.ready;
	};
	this.ready.notify = function() { };


	this.init = function(request) {
		this.request = request;
		this.ready.notify();
	};

	this.initFromJson = function(json_string) {
		this.init(JSON.parse(json_string));
	};

	this.backToKorona = function() {
		window.close();
	};

	this.showOsk = function() {
		if (typeof this.bridge === 'undefined')
			return;
		this.bridge.showOsk();
	}

	this.hideOsk = function() {
		if (typeof this.bridge === 'undefined')
			return;
		this.bridge.hideOsk();
	}
};

// module.exports = korona_plugin_api;
