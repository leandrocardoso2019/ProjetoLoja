import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { DetalhepedidoPageRoutingModule } from './detalhepedido-routing.module';

import { DetalhepedidoPage } from './detalhepedido.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    DetalhepedidoPageRoutingModule
  ],
  declarations: [DetalhepedidoPage]
})
export class DetalhepedidoPageModule {}
