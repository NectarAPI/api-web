<template>
    <b-modal
        id="information-modal"
        title="Learn more"
        class="col-6"
        @shown="focusSection" >
        <div class="information_panel" id="information_panel">
            <h3 id="encrypted-configuration">Encrypted STS configuration</h3>
            <p>
                STS configurations sent using this portal must be encyrpted first. The following steps are required to generate an encypted STS configuration:
                <ol>
                    <li>
                        <h4>Create the STS configuration YAML</h4>
                        <p>An STS configuration must be created in the form of a YAML file. Below is an example of an STS configuration with all required fields. 
                            The file can be saved using any name and with any extension desired.
                            <span class="code">
                                <pre>
---
name: example_config
type: native
key_expiry_no: 255
encryption_algorithm: sta
token_carrier_type: numeric
decoder_key_generation_algorithm: 04
tariff_index: 01
key_revision_no: 1
vending_key: 0123456789abcdef
supply_group_code: 123456
key_type: 3
base_date: 2035
issuer_identification_no: 600727
                                </pre>
                            </span>
                        </p>
                    </li>
                    <li>
                        <h4>Encrypt the STS Configuration</h4>
                        <p>Use an 128 bit AES Key to encrypt the STS configuration. 
                            An example of a 128 bit AES Key is <span class="highlight">v8y/B?E(H+MbQeTh</span>.
                            Note the number of characters in this key is 16 ASCII chars.
                        </p>
                    </li>
                    <li>
                        <h4>Base64 encoded output</h4>
                        <p>The output generated from the symmetric encryption using the 128 bit AES key should then be base64 encoded</p>
                    </li>
                </ol> 
            </p>
            <p>
                The following commands can be used to encrypt an STS configuration using a symmetric key and base64 encode the output.
                <span class="code">
                    <pre>
<span class="comment">These set of commands use the IV `1234567812345678` </span>
<span class="comment">and symmetric key `v8y/B?E(H+MbQeTh`</span>

echo -n -e 1234567812345678 > iv.txt
echo -n -e "v8y/B?E(H+MbQeTh" > sym.txt

<span class="comment">Convert the sym and IV to hex</span>
xxd -p -l 16 &lt;&lt;&lt; cat iv.txt # outputs 7638792f423f4528482b4d6251655468
xxd -p -l 16 &lt;&lt;&lt; cat sym.txt # outputs 7638792f423f4528482b4d6251655468

<span class="comment">Encrypt your STS config using the IV and symmetric key</span> 
openssl enc -aes-128-cbc -in sts_config.yml -out encrypted_sts_config_no_iv.bin -K  7638792f423f4528482b4d6251655468 -iv 31323334353637383132333435363738

<span class="comment">Concatentate the IV and encrypted STS config output</span>
cp iv.txt encrypted_sts_config_with_iv.bin
cat encrypted_sts_config_no_iv.bin >> encrypted_sts_config_with_iv.bin

<span class="comment">base64 the resultant encrypted IV and STS config</span>
cat encrypted_sts_config_with_iv.bin | base64 > encrypted_sts_config_with_iv_base64.txt
                    </pre>
                </span>
            </p><br/><br/><br/><hr/><br/><br/><br/>

            <h3 id="encrypted-message-digest">Encrypted configuration digest</h3>
            <p>
                A message digest of the STS config has to be generated using <span class="highlight">SHA-256</span>. The hashed 
                message digest then has to be encrypted with your private key. This private key's, public key pair must already have been uploaded into 
                the Nectar portal. Public keys can be managed using the <a href="/public-keys">Public Keys</a> page. The PKI key pair are 4096 bit RSA Keys.
                The output of the <span class="highlight">SHA-256</span> must then be base64 encoded.
            </p>
            <p>
                The following commands can be used to generate a<span class="highlight">SHA-256</span> hash of the STS configuration file and encrypt the configuration file 
                using an RSA private key.
                <span class="code">
                    <pre>
<span class="comment">== Perform the following, if not already done</span>

<span class="comment">Generate RSA private key</span>
openssl genrsa -out key.pem 4096 

<span class="comment">Extract the public key</span>
openssl rsa -in key.pem -pubout > public.pub 
<span class="comment">This public key must be uploaded to http://portal.nectar.co.ke/public-keys before next steps</span>

<span class="comment">== end</span>

<span class="comment">Generate SHA256 digest and sign encrypting it with your private key</span>
cat sts_config.yml | openssl dgst -binary -sha256 | openssl rsautl -sign -inkey user_key.pem -in - -out - | openssl base64 > encrypted_digest.txt
                    </pre>
                </span>
            </p> <br/><br/><br/><hr /><br/><br/><br/>
            
            <h3 id="encrypted-symmetric-key">Encrypted symmetric key</h3>
            <p>
               Any 128 bit AES Key symmetric key can be used to encrypt an STS configuration. An example is <span class="highlight">v8y/B?E(H+MbQeTh</span>. 
               This symmetric key must be encrypted using Nectar's Public Key available <a href="/resources/nectar_public.pub" download>here</a>.  
            </p>
            <p>
                The following commands can be used to encrypt the symmetric key using Nectar's public key. 
                 <span class="code">
                     <pre>
<span class="comment">Encrypt symmetric key using public key</span>
openssl rsautl -encrypt -pubin -inkey nectar_public.pub -in sym.txt -out encrypted_symmetric.bin

<span class="comment">Convert to base64 encoding</span>
base64 encrypted_symmetric.bin > encrypted_symmetric.txt 
                    </pre>
                </span>
            </p><br/><br/><br/><hr/><br/><br/><br/>


            <h3 id="symmetric-key">Symmetric Key</h3>
            <p>
               Any 128 bit AES Key symmetric key can be used to encrypt an STS configuration. An example is <span class="highlight">v8y/B?E(H+MbQeTh</span>.  
            </p>
            <p>
                The following command shows how a symmetric key can be created. 
                 <span class="code">
                     <pre>

<span class="comment">Generate RSA private key</span>
echo -n -e "v8y/B?E(H+MbQeTh" > sym.txt
                    </pre>
                </span>
            </p><br/><br/><br/><hr/><br/><br/><br/>

            <h3 id="private-key">Private Key</h3>
            <p>
                A 4096 bit RSA key pair is required for Nectar API encryption. While a private key is required here, the private key is not transmitted 
                over the internet. Instead, it is used to encrypt the STS config digest locally on the client browser.   
            </p>
            <p>
                The following command shows how a private key can be created. 
                 <span class="code">
                     <pre>
<span class="comment">Generate RSA private key</span>
openssl genrsa -out key.pem 4096 

<span class="comment">Extract the public key</span>
openssl rsa -in key.pem -pubout > public.pub 
<span class="comment">This public key must be uploaded to <a href="/public-keys">Public Keys</a> before use.</span>

                    </pre>
                </span>
            </p><br/><br/><br/><hr/><br/><br/><br/>

        </div>
    </b-modal>
</template>
<script>
export default {
    name: 'InformationComponent',
    props: [
        'label',
    ],
    data() {
      return {
      }
    },
    methods: {
        focusSection() {
            var top = document.getElementById(this.label).offsetTop;
            var contentDiv = document.getElementById('information_panel')
            contentDiv.scrollTo(0, top - 10);
        },
    }
}
</script>
<style scoped>
.information_panel {
    width: 100%;
    height: 300px;
    overflow-y: scroll;
}
h3 {
    margin-top: 1em;
}
span.code, span.code > pre {
    display: block;
    width: 100%;
    background: #000;
    color: #fff;
    font-family: 'Courier New', Courier, monospace;
    padding: 0 0 0 1em;
    font-size: 12px;
    margin: 1em 0;
}
span.highlight {
    border: 1px solid #bdd0f7;
    height: 1.5em;
    padding: 0.2em;
    margin: 0;
    color: #696ffb;
}
p {
    margin: 1em 0
}
span.comment {
    color: #ffff00;
}
</style>
